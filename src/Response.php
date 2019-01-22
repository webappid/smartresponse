<?php
/**
 * Created by PhpStorm.
 * User: dyangalih
 * Date: 2019-01-22
 * Time: 12:49
 */

namespace WebAppId\SmartResponse;

/**
 * Class Response
 * @package App\Libs\SmartResponse
 */
class Response
{
    private $code;
    private $message;
    private $data;
    private $view;
    private $redirect;
    
    /**
     * @return mixed
     */
    public function getCode()
    {
        return $this->code;
    }
    
    /**
     * @param mixed $code
     */
    public function setCode($code)
    {
        $this->code = $code;
    }
    
    /**
     * @return mixed
     */
    public function getMessage()
    {
        return $this->message;
    }
    
    /**
     * @param mixed $message
     */
    public function setMessage($message)
    {
        $this->message = $message;
    }
    
    /**
     * @return mixed
     */
    public function getData()
    {
        return $this->data;
    }
    
    /**
     * @param mixed $data
     */
    public function setData($data)
    {
        $this->data = $data;
    }
    
    /**
     * @return \Illuminate\View\View
     */
    public function getView()
    {
        return $this->view;
    }
    
    /**
     * @param \Illuminate\View\View
     */
    public function setView($view)
    {
        $this->view = $view;
    }
    
    /**
     * @return mixed
     */
    public function getRedirect()
    {
        return $this->redirect;
    }
    
    /**
     * @param mixed $redirect
     */
    public function setRedirect($redirect)
    {
        $this->redirect = $redirect;
    }
    
}