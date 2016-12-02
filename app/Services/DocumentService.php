<?php

namespace App\Services;
use Illuminate\Database\Eloquent\Model;
use Storage;
use Imagick;
use DB;
use App;
use Auth;
use Response;

class DocumentService
{

    // Pass array of document IDs
    public function getDocuments($docs)
    {
        $docs = DB::table('documents')
            ->whereIn('documents.id', $docs)
            ->select('documents.id as document_id', 'documents.group_id')
            ->get();

        foreach($docs as &$doc) {
            $doc->metaTags = DB::table('document_meta_tags')
                ->join('meta_tags', 'meta_tags.id', '=', 'document_meta_tags.meta_tag_id')
                ->where('document_meta_tags.document_id', $doc->document_id)
                ->select('meta_tags.name', 'document_meta_tags.value')
                ->get();
        }
        return $docs;
    }

    private function syncTags($docID, $tags) {
        $keys = [];
        foreach($tags as $tag) {
            $keys[$tag->name] = -1;
        }
        $dbRet = DB::table('meta_tags')
            ->whereIn('name', array_keys($keys))
            ->select('name', 'id')->get();

        foreach($dbRet as $keyID) {
            $keys[$keyID->name] = $keyID->id;
        }
        foreach($keys as $key => $value) {
            if($value == -1) {
                $keys[$key] = DB::table('meta_tags')->insertGetId( ['name' => $key]);
            }
        }

        foreach($tags as &$tag) {
            $tag->document_id = $docID;
            $tag->meta_tag_id = $keys[$tag->name];
            unset($tag->name);
            $tag = (array)$tag;
        }

        DB::table('document_meta_tags')->where('document_id', $docID)->delete();
        DB::table('document_meta_tags')->insert($tags);

    }

    public function createDocument($file, $group, $tags)
    {
        $filePath = $file->getRealPath();

        // Convert image to jpg for simplicity
        $image = new Imagick($filePath);
        $image->setImageFormat('jpeg');
        $image->writeImages($filePath, true);

        $hash = md5_file($filePath);
        $finalPath = $group . '/' . $hash . '.jpg';
        if(!Storage::disk('imageStore')->put(
           $finalPath,
           file_get_contents($filePath))) {
            return response()->json('Error: Could not save image.', 415);
        }

        $doc = new App\Document(
            [
                'path' => $finalPath,
                'user_id' => Auth::id(),
                'group_id' => (int)$group,
                'mime_type' => 'image/jpeg'
            ]
        );

        $doc->save();

        $origFileName = $file->getClientOriginalName();
        $tags []= (object)['name' => 'name','value' => $origFileName];
        DocumentService::syncTags($doc->id, $tags);

        return response()->json(DocumentService::getDocuments([$doc->id]));
    }

    public function updateDocument($document_id, $tags)
    {
        DocumentService::syncTags($document_id, $tags);
        return response()->json(DocumentService::getDocuments([$document_id]));
    }

    public function hasDocAccess($document_id)
    {
        $doc = DB::table('users')
            ->join('users_groups', 'users.id', '=', 'users_groups.user_id')
            ->join('documents', 'users_groups.group_id', '=', 'documents.group_id')
            ->where([
                ['users.id', auth::id()],
                ['documents.id', $document_id]])
                ->value('users_groups.is_admin');

        if(func_num_args() == 2 && func_get_arg(1) == True){
            if($doc == True){
                return True;
            }
            if(DB::table('users')->where('id', Auth::id())->value('isAdmin') == True) {
                return True;
            }
            return False;
        }
        if(is_null($doc)) {
            if(DB::table('users')->where('id', Auth::id())->value('isAdmin') == True) {
                return True;
            }
            return False;
        }
        return True;
    }

    public function readDocument($document_id, $user)
    {
        $doc = DB::table('documents')->where('id', $document_id)->first();
        if(is_null($doc)) {
            return response()->json("Error: User is not authorized", 403);
        }
        $response = Response::make(Storage::disk('imageStore')->get($doc->path), 200);
        $response->header('Content-Type', $doc->mime_type);
        return $response;
    }

    public function destroyDocument($document_id)
    {
        $doc = DB::table('documents')
            ->where('documents.id', $document_id)
            ->first();
        if(is_null($doc)){
            return response()->json('File has been deleted');
        }

        DB::table('document_meta_tags')->where('document_id', '=', $doc->id)->delete();
        DB::table('documents_groups')->where('document_id', '=', $doc->id)->delete();
        DB::table('documents')->where('id', '=', $doc->id)->delete();

        if(DB::table('documents')->where('path', '=', $doc->path)->count() == 0) {
            Storage::disk('imageStore')->delete($doc->path);
        }

        return response()->json('File has been deleted');
    }

    public function searchDocument($search, $user)
    {
        $paramArray = array();
        $strings = explode(' ', $search);
        $stmt  = 'SELECT documents.id ';
        $stmt .= 'FROM document_meta_tags ';
        $stmt .= 'INNER JOIN documents ON document_meta_tags.document_id = documents.id ';
        $stmt .= 'INNER JOIN users_groups ON users_groups.group_id = documents.group_id ';
        $stmt .= 'INNER JOIN users ON users.id = users_groups.user_id ';
        $stmt .= 'WHERE users.id = ? and ( ';
        $paramArray[] = $user['id'];

        foreach($strings as $val) {
            $stmt .= 'document_meta_tags.value like ? or ';
            $paramArray[] = '%'.$val.'%';
        }
        $stmt = substr($stmt, 0, -4);
        $stmt .= ')';

        $ret = DB::select($stmt, $paramArray);
        $docs = [];

        foreach($ret as $doc) {
            $docs[] = $doc->id;
        }

        return response()->json(DocumentService::getDocuments($docs));
    }


}
