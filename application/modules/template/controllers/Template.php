<?php

class Template extends MY_Controller
{

    public function __construct(){

        parent:: __construct();
    }

    public function loadTemplate($page_content = "")
    {
        $data["page_content"] = $page_content;
        $this->load->view("template/global_template", $data);
    }




    public function my_views() 
    {
        $this->loadTemplate("template/my_view");

    }

    public function newView()
    {
        echo "<h3>THIS IS MY NEW VIEW</h3>";
    }

}

?>