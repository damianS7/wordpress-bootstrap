<?php
namespace Xtube\Backend\Importers;

use Xtube\Backend\Controllers\VideoImportController;
use Xtube\Backend\Importers\Youtube;

class AutoImport {
    public static function import($server, $keyword, $num_vids_to_import) {
        $videos = Youtube::search($keyword, 1);

        foreach ($videos as $video) {
            VideoImportController:import($videos);
        }
    }
}