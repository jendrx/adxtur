<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link      http://cakephp.org CakePHP(tm) Project
 * @since     0.2.9
 * @license   http://www.opensource.org/licenses/mit-license.php MIT License
 */
namespace App\Controller;

use Cake\Controller\Controller;
use Cake\Event\Event;

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @link http://book.cakephp.org/3.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller
{

    /**
     * Initialization hook method.
     *
     * Use this method to add common initialization code like loading components.
     *
     * e.g. `$this->loadComponent('Security');`
     *
     * @return void
     */
    public function initialize()
    {
        parent::initialize();

        $this->loadComponent('RequestHandler');
        $this->loadComponent('Flash');

        $this->loadComponent('Auth',['loginRedirect' => ['controller' => 'Homes', 'action' => 'index'],
                            'logoutRedirect' => ['controller' => 'Domains', 'action' => 'index']]);

        /*
         * Enable the following components for recommended CakePHP security settings.
         * see http://book.cakephp.org/3.0/en/controllers/components/security.html
         */
        //$this->loadComponent('Security');
        //$this->loadComponent('Csrf');
    }


    //BeforeFilter() function was to tell the AuthComponent to not require a login for all index() and view() actions, in every controller.
    //We want our visitors to be able to read and list the entries without registering in the site.

//    public function beforeFilter(Event $event)
//    {
//        $this->Auth->allow(['index','view','display']);
//    }
    /**
     * Before render callback.
     *
     * @param \Cake\Event\Event $event The beforeRender event.
     * @return \Cake\Network\Response|null|void
     */
    public function beforeRender(Event $event)
    {
        if (!array_key_exists('_serialize', $this->viewVars) &&
            in_array($this->response->type(), ['application/json', 'application/xml'])
        ) {
            $this->set('_serialize', true);
        }
    }

    public function uploadFile($folder, $formdata, $itemId = null)
    {
        $allowed_type = 'text/csv';
        $folder_url = WWW_ROOT.$folder;
        $success= false;
        $rel_url = $folder;
        $result = null;
        $filename = str_replace(' ', '_', $formdata['name']);

        if ($formdata['error'] == 0  && $formdata['type'] == $allowed_type) {
            if (!file_exists($folder_url.DS.$filename)) {
                $full_url = $folder_url.DS.$filename;
                $url = $rel_url.'/'.$filename;
                $success = move_uploaded_file($formdata['tmp_name'], $full_url);
            }
        }

        if ($success) {
            $result = $full_url;
        }

        return $result;

    }
}
