<?php

class Pagination {

    public $current_page;
    public $records_per_page;
    public $total_records;

//    public function __construct($current_page = 1, $records_per_page = 20, $total_records = 0) {
//        $this->current_page = (int) $current_page;
//        $this->records_per_page = (int) $records_per_page;
//        $this->total_records = (int) $total_records;
//    }

    public function __construct($total_records = 0) {
        $this->total_records = (int) $total_records;
//        $this->records_per_page = !empty($_GET["records"]) ? (int) $_GET["records"] : 30;

        $records_per_page = 10;
        if (!empty($_GET["records"])) {
            if ($this->val_number($_GET["records"])) {
                $records_per_page = (int) $_GET["records"];
            } else {
                $records_per_page = 10;
            }
        }
        $this->records_per_page = $records_per_page;

        $current_page = 1;
        if (!empty($_GET["page"])) {
            if ($this->val_number($_GET["page"])) {
                $page = (int) $_GET["page"];
                $tot_pages = (int) $this->total_pages();
                if ($page > $tot_pages) {
                    $current_page = $tot_pages;
                } else {
                    $current_page = $page;
                }
            }else{
                $this->current_page = $current_page;
            }
        }
        $this->current_page = $current_page;
    }
    
    public function val_number($value) {
        return preg_match("/^[0-9]+$/", $value);
    }
    

    public function offset() {
        return ($this->current_page - 1) * $this->records_per_page;
    }

    public function total_pages() {
        return ceil($this->total_records / $this->records_per_page);
    }

    public function previous_page() {
        $previous_page = $this->current_page - 1;
        return $previous_page;
    }

    public function next_page() {
        $next_page = $this->current_page + 1;
        return $next_page;
    }

//    public function previous_page() {
//        $previous_page = $this->current_page - 1;
//        return ($previous_page > 0) ? $previous_page : $this->current_page;
//    }
//
//    public function next_page() {
//        $next_page = $this->current_page + 1;
//        return ($next_page <= $this->total_pages()) ? $previous_page : $this->current_page;
//    }

    public function has_previous_page() {
        return $this->previous_page() > 0;
    }

    public function has_next_page() {
        return $this->next_page() <= $this->total_pages();
    }

    public function get_pagination_links_html($page) {
        $html = "";

        $html .= '<select class="select">';
        $html .= '<option ' . (($this->records_per_page == "10") ? "selected" : "") . ' onclick="window.location.href=\'?page=' . $this->current_page . '&records=10\' ">10</option>';
        $html .= '<option ' . (($this->records_per_page == "30") ? "selected" : "") . ' onclick="window.location.href=\'?page=' . $this->current_page . '&records=30\' ">30</option>';
        $html .= '<option ' . (($this->records_per_page == "50") ? "selected" : "") . ' onclick="window.location.href=\'?page=' . $this->current_page . '&records=50\' ">50</option>';
        $html .= '<option ' . (($this->records_per_page == "100") ? "selected" : "") . ' onclick="window.location.href=\'?page=' . $this->current_page . '&records=100\' ">100</option>';
        $html .= '</select>';

        if ($this->total_pages() > 1) {
            if ($this->has_previous_page()) {
                $html .= "<a href='" . $page . "?page=" . $this->previous_page() . "&records=" . $this->records_per_page . "' > &laquo&laquo  Previous </a>";
            }

            if ($this->has_next_page()) {
                $html .= "<a href='" . $page . "?page=" . $this->next_page() . "&records=" . $this->records_per_page . "' > Next &raquo&raquo</a>";
            }

            $html .= "<br/>";

            $total_pages = $this->total_pages();
            for ($i = 1; $i <= $total_pages; $i++) {
                if ($this->current_page == $i) {
                    $html .= "<a style='color:red' href='" . $page . "?page=" . $i . "' > {$i} </a>";
                } else {
                    $html .= "<a href='" . $page . "?page=" . $i . "' > {$i} </a>";
                }
            }
        }
        return $html;
    }

    public function get_pagination_links_html1($page) {
        $html = "";
        
//        if ($this->total_pages() > 1 ) {
            $html .= '<div class="pagination_outer">';

            $html .= '<div class="pagination_select">';
            $html .= '<select class="select" onchange="location = this.value;" >';

            $value = $page . "?page=" . $this->current_page . "&records=10";
            $html .= '<option ' . (($this->records_per_page == "10") ? "selected" : "") . ' value="' . $value . '" >10</option>';
            
            $value = $page . "?page=" . $this->current_page . "&records=30";
            $html .= '<option ' . (($this->records_per_page == "30") ? "selected" : "") . ' value="' . $value . '" >30</option>';

            $value = $page . "?page=" . $this->current_page . "&records=50";
            $html .= '<option ' . (($this->records_per_page == "50") ? "selected" : "") . '  value="' . $value . '" >50</option>';

            $value = $page . "?page=" . $this->current_page . "&records=100";
            $html .= '<option ' . (($this->records_per_page == "100") ? "selected" : "") . '  value="' . $value . '" >100</option>';

            $html .= '</select>';
            $html .= '</div>';
            
            $from=$this->offset()+1;
            $to= $this->offset()+($this->records_per_page);
            if($to > $this->total_records){
                $to=$this->total_records;
            }
            
            $html .= '<label>Showing '.$from.' to '.$to.' of '. $this->total_records.' entries</label>';
            
            $html .= '<br/>';
            $html .= '<div>';
            
            if ($this->has_previous_page()) {
                $html .= '<div class="pagination">';
                $html .= "<a href='" . $page . "?page=" . $this->previous_page() . "&records=" . $this->records_per_page . "' > <i class='fa fa-angle-double-left' aria-hidden='true'></i> Previous </a>";
                $html .= '</div>';
            }

           

            $total_pages = $this->total_pages();
            for ($i = 1; $i <= $total_pages; $i++) {
                $html .= '<div class="pagination">';
                if ($this->current_page == $i) {
                    $html .= "<a class='active' href='" . $page . "?page=" . $i . "&records=" . $this->records_per_page . "' > {$i} </a>";
                } else {
                    $html .= "<a href='" . $page . "?page=" . $i . "&records=" . $this->records_per_page . "' > {$i} </a>";
                }
                $html .= '</div>';
            }

            if ($this->has_next_page()) {
                $html .= '<div class="pagination">';
                $html .= "<a href='" . $page . "?page=" . $this->next_page() . "&records=" . $this->records_per_page . "' > Next <i class='fa fa-angle-double-right' aria-hidden='true'></i></a>";
                $html .= '</div>';
            }
            
            $html .= '</div>';

            $html .= '</div>';
//        }
        return $html;
    }

}
