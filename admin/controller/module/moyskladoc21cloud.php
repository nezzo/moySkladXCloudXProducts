<?php
ini_set('display_errors',1);
error_reporting(E_ALL ^E_NOTICE);

class Controllermodulemoyskladoc21cloud extends Controller
{
    private $error = array();
    public $mas;
    public $diapason;
    public $getAllProductID;
    public $mas_xls;
    public $getAPI = "GET";
    public $postAPI = "POST";
    public $putAPI = "PUT";
    public $deleteAPI = "DELETE";


    public function index()
    {

        $this->load->language('module/moyskladoc21cloud');
        $this->load->model('tool/image');

        //$this->document->title = $this->language->get('heading_title');
        $this->document->setTitle($this->language->get('heading_title'));

        $this->load->model('setting/setting');

        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
            $this->request->post['moyskladoc21cloud_order_date'] = $this->config->get('moyskladoc21cloud_order_date');
            $this->model_setting_setting->editSetting('moyskladoc21cloud', $this->request->post);
            $this->session->data['success'] = $this->language->get('text_success');
            //$this->response->redirect($this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'));
        }

        $data['heading_title'] = $this->language->get('heading_title');
        $data['entry_username'] = $this->language->get('entry_username');
        $data['entry_password'] = $this->language->get('entry_password');
        $data['text_tab_general'] = $this->language->get('text_tab_general');
        $data['text_tab_order'] = $this->language->get('text_tab_order');
        $data['entry_order_status'] = $this->language->get('entry_order_status');
        $data['entry_download'] = $this->language->get('entry_download');
        $data['diapason_text'] = $this->language->get('diapason_text');
        $data['text_tab_author'] = $this->language->get('text_tab_author');
        $data['text_tab_synchron'] = $this->language->get('text_tab_synchron');
        $data['button_save'] = $this->language->get('button_save');
        $data['button_cancel'] = $this->language->get('button_cancel');
        $data['button_downoload'] = $this->language->get('button_downoload');
        


        if (isset($this->error['warning'])) {
            $data['error_warning'] = $this->error['warning'];
        } else {
            $data['error_warning'] = '';
        }

        if (isset($this->error['image'])) {
            $data['error_image'] = $this->error['image'];
        } else {
            $data['error_image'] = '';
        }

        if (isset($this->error['moyskladoc21cloud_username'])) {
            $data['error_moyskladoc21cloud_username'] = $this->error['moyskladoc21cloud_username'];
        } else {
            $data['error_moyskladoc21cloud_username'] = '';
        }

        if (isset($this->error['moyskladoc21cloud_password'])) {
            $data['error_moyskladoc21cloud_password'] = $this->error['moyskladoc21cloud_password'];
        } else {
            $data['error_moyskladoc21cloud_password'] = '';
        }

        $data['breadcrumbs'] = array();

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_home'),
            'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], true)
        );


        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('heading_title'),
            'href' => $this->url->link('module/moyskladoc21cloud', 'token=' . $this->session->data['token'], true)
        );
        $data['token'] = $this->session->data['token'];

        $data['action'] = $this->url->link('module/moyskladoc21cloud', 'token=' . $this->session->data['token'], true);

        $data['cancel'] = $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL');;

        if (isset($this->request->post['moyskladoc21cloud_username'])) {
            $data['moyskladoc21cloud_username'] = $this->request->post['moyskladoc21cloud_username'];
         } else {
            $data['moyskladoc21cloud_username'] = $this->config->get('moyskladoc21cloud_username');
        }

        if (isset($this->request->post['moyskladoc21cloud_password'])) {
            $data['moyskladoc21cloud_password'] = $this->request->post['moyskladoc21cloud_password'];
         } else {
            $data['moyskladoc21cloud_password'] = $this->config->get('moyskladoc21cloud_password');
        }
 

        if (isset($this->request->post['moyskladoc21cloud_status'])) {
            $data['moyskladoc21cloud_status'] = $this->request->post['moyskladoc21cloud_status'];
        } else {
            $data['moyskladoc21cloud_status'] = $this->config->get('moyskladoc21cloud_status');
        }

        if (isset($this->request->post['moyskladoc21cloud_price_type'])) {
            $data['moyskladoc21cloud_price_type'] = $this->request->post['moyskladoc21cloud_price_type'];
        } else {
            $data['moyskladoc21cloud_price_type'] = $this->config->get('moyskladoc21cloud_price_type');
            if (empty($data['moyskladoc21cloud_price_type'])) {
                $data['moyskladoc21cloud_price_type'][] = array(
                    'keyword' => '',
                    'customer_group_id' => 0,
                    'quantity' => 0,
                    'priority' => 0
                );
            }
        }
 
        if (isset($this->request->post['moyskladoc21cloud_order_status'])) {
            $data['moyskladoc21cloud_order_status'] = $this->request->post['moyskladoc21cloud_order_status'];
        } else {
            $data['moyskladoc21cloud_order_status'] = $this->config->get('moyskladoc21cloud_order_status');
        }

        if (isset($this->request->post['moyskladoc21cloud_order_currency'])) {
            $data['moyskladoc21cloud_order_currency'] = $this->request->post['moyskladoc21cloud_order_currency'];
        } else {
            $data['moyskladoc21cloud_order_currency'] = $this->config->get('moyskladoc21cloud_order_currency');
        }


        // Группы
        $this->load->model('customer/customer_group');
        $data['customer_groups'] = $this->model_customer_customer_group->getCustomerGroups();

        $this->load->model('localisation/order_status');

        $order_statuses = $this->model_localisation_order_status->getOrderStatuses();

        foreach ($order_statuses as $order_status) {
            $data['order_statuses'][] = array(
                'order_status_id' => $order_status['order_status_id'],
                'name' => $order_status['name']
            );
        }

        $this->template = 'module/moyskladoc21cloud.tpl';
        $this->children = array(
            'common/header',
            'common/footer'
        );

        $data['heading_title'] = $this->language->get('heading_title');
        $data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');
        $this->response->setOutput($this->load->view('module/moyskladoc21cloud.tpl', $data));

        //$this->response->setOutput($this->render(), $this->config->get('config_compression'));
    }

    public function download()
    {

        if (isset($this->request->post['ot']) && isset($this->request->post['kolichestvo']) && $this->request->post['kolichestvo'] <= 1000) {
            $ot = $this->request->post['ot'];
            $kolichestvo = $this->request->post['kolichestvo'];

            $this->diapason = array(
                'ot' => $ot,
                'kolichestvo' => $kolichestvo
            );

            $data['link_xls'] = $this->downloadxls();

        }
    }

    private function validate()
    {

        if (!$this->user->hasPermission('modify', 'module/moyskladoc21cloud')) {
            $this->error['warning'] = $this->language->get('error_permission');
        }

        return !$this->error;

    }

    public function install()
    {
    }

    public function uninstall()
    {
    }
 
 
    public function cat($category_id)
    {
        $this->load->model('tool/moyskladoc21cloud');

        $results = $this->model_tool_moyskladoc21cloud->getCat($category_id);

        $this->mas = array();
        foreach ($results as $result) {
            if ($result['parent_id'] != 0) {
                $this->cat($result['parent_id']);
            }
            $this->mas[$result['parent_id']] = $result['name'];

        }

        return $this->mas;

    }


    
     //c помощью API получаем весь товар и заносим в базу магазина
    function getAllProductMoySklad(){

        //с настроек получаем логин и пароль к Моему Складу
        $login = $this->config->get('moyskladoc21cloud_username');
        $pass = $this->config->get('moyskladoc21cloud_password');
        
        //получаем текущий язык магазина
        $data['lang'] = $this->language->get('code');
        $lang = $this->model_tool_moyskladoc21cloud->getLanguageId($data['lang']);
           
           //получаем значение с какой строки получать товар
           if (isset($this->request->post["countAPIMoySklad"])){
            $counts = $this->request->post["countAPIMoySklad"];
            }
    
          //$urlProduct = "entity/product?offset=$counts&limit=100";
            $urlProduct = "entity/product?offset=$counts&limit=1";
            $product = $this->getNeedInfo($login,$pass,$urlProduct,$this->getAPI);

             
                for($i=0; $i<100; $i++){
                //если дошли до конца списка то выходим из рекурсии
                if(empty($product["rows"][$i]["name"])){
                    exit();
                }
                
                echo $product["rows"][$i]["name"];
                
             } 

            //вызов рекурсии  
            $this->getAllProductMoySklad($counts+$i);

            
    }
    
    //получаем нужную информацию
    function getNeedInfo($login,$password,$url,$method){                                                                                                              
        $ch = curl_init(); 
        curl_setopt($ch, CURLOPT_URL, "https://online.moysklad.ru/api/remap/1.1/".$url);    
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 20);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);     
        curl_setopt($ch, CURLOPT_USERPWD, $login.":".$password);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC); 
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(   
            'Accept: application/json',
            'Content-Type: application/json')                                                           
        );             

        if(curl_exec($ch) === false)
        {
            echo 'Curl error: ' . curl_error($ch);
        } 
        
        $errors = curl_error($ch);                                                                                                            
        $result = curl_exec($ch);
        $returnCode = (int)curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);  

         return json_decode($result, true);
    }
}
?>