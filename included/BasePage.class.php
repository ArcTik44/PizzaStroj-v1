<?php 
abstract class BasePage{

    protected MustacheRunner $m;
    protected string $title;


    public function __construct()
    {
        $this->m = new MustacheRunner();
    }

    public function render():void{
            $this->setUp();
            $html = $this->header();
            $html .= $this->body();
            $html .= $this->footer();
            echo $html;
            $this->wrapUp();
    }

    protected function setUp():void{}
    protected function header():string{

        return $this->m->render("head",["title"=>$this->title]);
    }

    protected abstract function body():string;
    
    protected function footer():string{
        return $this->m->render("foot");
    }
    protected function wrapUp():void{}
}