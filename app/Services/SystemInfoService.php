<?php

namespace App\Services;
use DB;

class SystemInfoService
{
    public function getSystemInfo()
    {
        // TODO
    }

    public function getAdminPageInfo()
    {
        $user = DB::select("SELECT COUNT(*) FROM users")[0]->{'COUNT(*)'};
        $doc = DB::select("SELECT COUNT(*) FROM documents")[0]->{'COUNT(*)'};
        return response()->json(["running" => "Yes",
                                 "total_user" => $user,
                                 "total_doc" => $doc]);
    }
}
