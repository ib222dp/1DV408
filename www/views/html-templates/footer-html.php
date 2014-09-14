<?php
namespace LoginApp\View;

class FooterHtml {

    public function __construct() {
    }

    public function getHtml() {

        $dateStr = sprintf("%s den %d %s år %d. Klockan är [%s:%s:%s].", ucFirst(strftime("%A")) , date("j"), lcFirst(date("F")), date("Y"), date("H"), date("i"), date("s"));
        return '<footer>
            ' . $dateStr . '
        </footer>';
    }
}
