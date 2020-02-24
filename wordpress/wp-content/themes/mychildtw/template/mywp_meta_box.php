<?php
    class mywp_meta_box{
        private $id;
        private $title;
        private $post_type;
        private $fields = [];

        /**
         * mywp_meta_box constructor.
         * @param $id id de la box
         * @param $title titre de la box
         * @param $post_type type de post pour la box
         */
        public function __construct($id, $title, $post_type)
        {
            add_action('add_meta_boxes',array(&$this,'create'));
            add_action('save_post',array(&$this,'save'));
            $this->id = $id;
            $this->title = $title;
            $this->post_type = $post_type;
        }

        public function create(){
            add_meta_box($this->id,$this->title,array(&$this,'render'),$this->post_type);
        }
        public function save(){

        }
        public function render(){
            global $post;
            foreach ($this->fields as $field){
                extract($field);
                $value = get_post_meta($post->ID,$id,true);
                if ($value == ''){
                    $value = $default;
                }
                require __DIR__.'/'.$field['type'].'.php';
            }
            $value = get_post_meta($post->ID,'test',true);

            echo '<input type="hidden" name="<?php echo $this->id ?>_nonce" value="<?php echo wp_create_nonce($this->id) ?>">';
        }

        public function add($id,$label,$type ='text',$default='')
        {
            $this->fields[] = [
                'id' => $id,
                'name' => $label,
                'type' => $type,
                'default' => $default
            ];
            return $this;
        }
}
