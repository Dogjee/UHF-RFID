<?php
    class sach{
        private $id;
        private $x;
        private $y;
        private $trangThai;
        function __construct($id,$x,$y,$trangThai)
        {
            $this->id = $id;
            $this->x = $x;
            $this->y = $y;
            $this->trangThai = $trangThai;
        }

        public function getId(){
            return $this->id;
        }
        public function getX(){
            return $this->x;
        }
        public function getY(){
            return $this->y;
        }
        public function getTrangThai(){
            return $this->trangThai;
        }

        public function setId($id){
            $this->id = $id;
        }
        public function setX($x){
            $this->x = $x;
        } 
        public function setY($y){
            $this->y = $y;
        } 
        public function setTrangThai($tt){
            $this->trangThai = $tt;
        }

    }
?>
<?php 
    class vatCan{
        private $x;
        private $y;

        public function __construct($x,$y)
        {
            $this->x = $x;
            $this->y = $y;
        }
        public function getX(){
            return $this->x;
        }
        public function getY(){
            return $this->y;
        }
        public function setX($x){
            $this->x = $x;
        }
        public function setY($y){
            $this->y = $y;
        }
    }
?>
<?php 
    class duongDi{
        private $x;
        private $y;

        public function __construct($x,$y)
        {
            $this->x = $x;
            $this->y = $y;
        }
        public function getX(){
            return $this->x;
        }
        public function getY(){
            return $this->y;
        }
        public function setX($x){
            $this->x = $x;
        }
        public function setY($y){
            $this->y = $y;
        }
    }
?>


<?php 
    class matPhang{
        private $mp ;
        public function __construct($a){
            $this->mp = $a;
        }

        public function in(){
            print_r($this->mp) ;
        }
        
        public function getMp(){
            return $this->mp;
        }

        public function setMp($a){
            $this->mp = $a;
        }

        public function themVatCan(vatCan $a){
            $x = $a->getX();
            $y = $a->getY();
            $this->mp[$x][$y]= 1;
        }

        public function themDuongDi(duongDi $a){
            $x = $a->getX();
            $y = $a->getY();
            $this->mp[$x][$y]= -1;
        }
        public function themSach(sach $a){
            $x = $a->getX();
            $y = $a->getY();
            $this->mp[$x][$y]= $a->getId();
        }
    }
?>
<?php 

    // $table= [[]];
    // for($row=0; $row< 3; $row++){
    //     for($col=0; $col < 3; $col++){
    //         $table[$row][$col]= 0;
    //     }
    // }
    // $a = new matPhang($table);
    // print_r($a);
    // $sach1 = new sach(1,1,1,'false');
    // $a->themSach($sach1);
    // print_r($a);

?>