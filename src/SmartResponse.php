<?php
/**
 * Created by PhpStorm.
 * User: dyangalih
 * Date: 2019-01-21
 * Time: 23:52
 */

namespace WebAppId\SmartResponse;

use Illuminate\Http\Request;

/**
 * Class SmartResponse
 * @package App\Libs\SmartResponse
 */
class SmartResponse
{
    
    /**
     * @param $response
     * @return array
     */
    private function responseJson(Response $response): array
    {
        $jsonResponse = Array();
        $jsonResponse['message'] = $response->getMessage();
        $jsonResponse['code'] = $response->getCode();
        $jsonResponse['data'] = $response->getData();
        $draw = $response->getDraw();
        if ($draw != null) {
            $jsonResponse['draw'] = $draw;
        }
        $recordsFiltered = $response->getRecordsFiltered();
        if ($recordsFiltered != null) {
            $jsonResponse['recordsFiltered'] = $recordsFiltered;
        }
        $recordsTotal = $response->getRecordsTotal();
        if ($recordsTotal != null) {
            $jsonResponse['recordsTotal'] = $recordsTotal;
        }
        
        return $jsonResponse;
    }
    
    /**
     * @param $response
     * @param $redirect
     * @return \Illuminate\Http\RedirectResponse
     */
    private function getRedirect(Response $response, $redirect)
    {
        if ($response->getRedirect() == null) {
            return back()->withInput();
        } else {
            return $redirect;
        }
    }
    
    /**
     * Method for final result
     *
     * @param Response $response
     * @param Request $request
     * @return \Illuminate\Http\Response | String $data | JSON $data
     */
    private function formatData(Response $response, Request $request = null)
    {
        if ($response->getMessage() == null) {
            $response->setMessage(trans('message.' . $response->getCode()));
        }
        
        if ($response->getCode() == null) {
            $response->setCode('200');
        }
        
        if($response->getData() ==  null){
            $response->setData(array());
        }
        
        if (request()->wantsJson() || ($request != "" && $request->wantsJson())) {
            return $this->responseJson($response);
        } else {
            if ($response->getRedirect() != null) {
                $redirect = redirect($response->getRedirect())->with('code', $response->getCode())->with('message', $response->getMessage());
                return $this->getRedirect($response, $redirect);
            } else {
                return $this->returnHtml($response);
            }
        }
    }
    
    /**
     * @param Response $response
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|null
     */
    private function returnHtml(Response $response)
    {
        if (view()->exists($response->getView())) {
            return view($response->getView(), $response->getData());
        } else {
            if (env("APP_DEBUG")) {
                dd('No Blade Template Found');
            } else {
                abort(404);
            }
            return null;
        }
    }
    
    /**
     * Method call for not not complete request
     *
     * @param Response $response
     * @param Request $request
     * @return \Illuminate\Http\Response | String $data
     */
    public function requestNotComplete(Response $response, Request $request = null)
    {
        $response->setCode('204');
        return $this->formatData($response, $request);
    }
    
    /**
     * Method if data not found
     *
     * @param Response $response
     * @param Request $request
     * @return \Illuminate\Http\Response | String $data
     */
    public function dataFound(Response $response, Request $request = null)
    {
        $response->setCode('302');
        return $this->formatData($response, $request);
    }
    
    /**
     * Method for request denied
     *
     * @param Response $response
     * @param Request $request
     * @return \Illuminate\Http\Response | String $data
     */
    public function requestDenied(Response $response, Request $request = null)
    {
        $response->setCode('401');
        return $this->formatData($response, $request);
    }
    
    /**
     * Method if data not found
     *
     * @param Response $response
     * @param Request $request
     * @return \Illuminate\Http\Response | String $data
     */
    public function dataNotFound(Response $response, Request $request = null)
    {
        $response->setCode('404');
        return $this->formatData($response, $request);
    }
    
    /**
     * Method for forbidden access
     *
     * @param Response $response
     * @param Request $request
     * @return \Illuminate\Http\Response | String $data
     */
    public function forbiddenAccess(Response $response, Request $request = null)
    {
        $response->setCode('403');
        return $this->formatData($response, $request);
    }
    
    /**
     * Method for save data failed
     *
     * @param Response $response
     * @param Request $request
     * @return \Illuminate\Http\Response | String $data
     */
    public function saveDataFailed(Response $response, Request $request = null)
    {
        $response->setCode('406');
        return $this->formatData($response, $request);
    }
    
    /**
     * Method for save data success
     *
     * @param Response $response
     * @param Request $request
     * @return \Illuminate\Http\Response | String $data
     */
    public function saveDataSuccess(Response $response, Request $request = null)
    {
        $response->setCode('201');
        return $this->formatData($response, $request);
    }
    
    /**
     * Method for success request
     *
     * @param Response $response
     * @param Request $request
     * @return \Illuminate\Http\Response | String $data
     */
    public function success(Response $response, Request $request = null)
    {
        $response->setCode('200');
        return $this->formatData($response, $request);
    }
    
    /**
     * @param Response $response
     * @param Request $request
     * @return \Illuminate\Http\Response | String
     */
    public function globalResponse(Response $response, Request $request = null)
    {
        return $this->formatData($response, $request);
    }
}