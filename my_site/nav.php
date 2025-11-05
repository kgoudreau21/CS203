<?php
    class menu{
        public $current_page;
        public $links;

        function __construct($current_page){
            //if $current_page is not an empty string then set it to $this->current_page, else set it to index.php
            $this->current_page= (strlen($current_page) > 0) ? $current_page : 'index.php';

            //array using key value pairs, key=href and value=(text inside <a>)
            $this->links=['index.php'=>'Home', 'to-do.php'=>'To Do list', 'my_vacation.php'=>'My Dream Vacation!', 'my_artistic_self.php'=>'My Artistic Side!', 'my_form.php'=>'My Form'];
        }

        public function setNav(){
            $msg='';

            foreach($this->links as $key=>$value){
                if($this->current_page===$key){ //set class="current_page" to .php page in $current_page
                    $msg.='<a href="'.$key.'?page='.$key.'" class="current_page">'.$value.'</a>';
                }else{
                    $msg.='<a href="'.$key.'?page='.$key.'">'.$value.'</a>';
                }
            }
            
            print('<nav id="main-nav">'.$msg.'</nav>');
        }

        public function setFooter(){
            print("<footer><p>This Website was made &amp; Bishops University CS203 Labs!</p></footer>");
        }
    }

    //if URL has data appended: page='current_page' then call function with parameter='current_page', else parameter=(empty string)
    $webpage = new menu(isset($_GET['page']) ? $_GET['page'] : '');
?>