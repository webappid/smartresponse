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
    private $draw;
    private $code;
    private $message;
    private $data;
    private $view;
    private $redirect;
    private $recordsFiltered;
    private $recordsTotal;
    
    /**
     * @return string|null
     */
    public function getCode(): ?string
    {
        return $this->code;
    }
    
    
    /**
     * @param string $code
     */
    public function setCode(string $code)
    {
        $this->code = $code;
    }
    
    /**
     * @return string|null
     */
    public function getMessage(): ?string
    {
        return $this->message;
    }
    
    /**
     * @param string $message
     */
    public function setMessage(string $message)
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
     * @return string|null
     */
    public function getView(): ?string
    {
        return $this->view;
    }
    
    
    /**
     * @param string $view
     */
    public function setView(string $view)
    {
        $this->view = $view;
    }
    
    
    /**
     * @return string|null
     */
    public function getRedirect(): ?string
    {
        return $this->redirect;
    }
    
    
    /**
     * @param string $redirect
     */
    public function setRedirect(string $redirect)
    {
        $this->redirect = $redirect;
    }
    
    
    /**
     * @return int|null
     */
    public function getRecordsFiltered(): ?int
    {
        return $this->recordsFiltered;
    }
    
    /**
     * @param mixed $recordsFiltered
     */
    public function setRecordsFiltered(int $recordsFiltered): void
    {
        $this->recordsFiltered = $recordsFiltered;
    }
    
    /**
     * @return int|null
     */
    public function getRecordsTotal(): ?int
    {
        return $this->recordsTotal;
    }
    
    
    /**
     * @param int $recordsTotal
     */
    public function setRecordsTotal(int $recordsTotal): void
    {
        $this->recordsTotal = $recordsTotal;
    }
    
    
    /**
     * @return int|null
     */
    public function getDraw(): ?int
    {
        return $this->draw;
    }
    
    /**
     * @param mixed $draw
     */
    public function setDraw(int $draw): void
    {
        $this->draw = $draw;
    }
    
}