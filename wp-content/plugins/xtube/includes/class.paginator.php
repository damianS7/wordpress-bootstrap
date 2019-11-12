<?php
namespace Xtube\Common;

class Paginator {
    // Metodo que devuelve un array con las paginas que corresponden a cada boton
    public static function get_pagination($total_pages, $current_page) {
        $pages = array();
        $last_printed_page = 1;

        if ($current_page > $total_pages) {
            $current_page = $total_pages;
        }

        if ($current_page <= 0) {
            $current_page = 1;
        }

        // Si estamos 5 paginas por delante de la 1 ...
        if ($current_page-6 >= 1) {
            $pages[] = '1';
            $pages[] = '...';

            // Mostramos las 5 paginas anteriores a la actual.
            for ($i=$current_page-5; $i < $current_page ; $i++) {
                $pages[] = $i;
            }
        } else {
            // Mostramos todas las paginas anteriores a la pagina actual
            for ($i=1; $i < $current_page ; $i++) {
                $pages[] = $i;
            }
        }

        // Si hay al menos 5 paginas disponibles hacia adelante ...
        if ($current_page+5 < $total_pages) {
            // Hacia delante
            for ($i=$current_page; $i <= $current_page+5 ; $i++) {
                $pages[] = $i;
            }
            
            $pages[] = '...';
            $pages[] = $total_pages;
        } else {
            // No hay 5 paginas como minimo, mostramos el resto
            for ($i=$current_page; $i <= $total_pages ; $i++) {
                $pages[] = $i;
            }
        }
        
        if ($current_page-1 >= 1) {
            $prev = $current_page-1;
        } else {
            $prev = 1;
        }

        if ($current_page+1 <= $total_pages) {
            $next = $current_page+1;
        } else {
            $next = $total_pages;
        }

        return array('first' => 1,
            'last' => $total_pages,
            'prev' => $prev,
            'next' => ($current_page+1),
            'actual' => $current_page,
            'total_pages' => $total_pages,
            'pages' => $pages
        );
    }
}