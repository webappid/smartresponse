<?php
/**
 * Created by PhpStorm.
 * User: dyangalih
 * Date: 2019-01-21
 * Time: 23:52
 */

namespace WebAppId\SmartResponse;

use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use function PHPUnit\Framework\isInstanceOf;

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
        $jsonResponse = array();
        $jsonResponse['message'] = $response->getMessage();
        $jsonResponse['code'] = $response->getCode();

        if (!is_array($response->getData()) && method_exists($response->getData(), 'items')) {
            $jsonResponse['data'] = $response->getData()->items();
        } else {
            $jsonResponse['data'] = $response->getData();
        }

        if (!is_array($response->getData()) && method_exists($response->getData(), 'perPage')) {
            $jsonResponse['per_page'] = $response->getData()->perPage();
        }

        if (!is_array($response->getData()) && method_exists($response->getData(), 'currentPage')) {
            $jsonResponse['current_page'] = $response->getData()->currentPage();
        }

        if (!is_array($response->getData()) && method_exists($response->getData(), 'path')) {
            $jsonResponse['path'] = $response->getData()->path();
        }

        $jsonResponse['draw'] = $response->getDraw() != null ? $response->getDraw() : 0;

        $jsonResponse['recordsFiltered'] = $response->getRecordsFiltered() != null ? $response->getRecordsFiltered() : 0;

        $jsonResponse['recordsTotal'] = $response->getRecordsTotal() != null ? $response->getRecordsTotal() : 0;

        return $jsonResponse;
    }

    /**
     * @param $response
     * @param $redirect
     * @return RedirectResponse
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
     * @param Request|null $request
     * @return \Illuminate\Http\Response | String $data | JSON $data
     */
    private function formatData(Response $response, Request $request = null)
    {
        if ($response->getMessage() == null) {
            $response->setMessage(trans('smartresponse::message.' . $response->getCode()));
        }

        if ($response->getCode() == null) {
            $response->setCode('200');
        }

        if ($response->getData() == null) {
            $response->setData(array());
        }

        if (request()->wantsJson() || ($request != "" && $request->wantsJson())) {
            return $this->responseJson($response);
        } else {
            if ($response->getRedirect() != null) {
                return redirect($response->getRedirect())
                    ->with('code', $response->getCode())
                    ->with('message', $response->getMessage())
                    ->withInput();
            } else {
                return $this->returnHtml($response);
            }
        }
    }

    /**
     * @param Response $response
     * @return Factory|View|null
     */
    private function returnHtml(Response $response)
    {
        if (view()->exists($response->getView())) {
            return view($response->getView(), $response->getData());
        } else {
            if (env("APP_DEBUG")) {
                dd('No HTML Template Found');
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
     * @param Request|null $request
     * @return \Illuminate\Http\Response | String $data
     */
    public function success(Response $response, Request $request = null)
    {
        $response->setCode('200');
        return $this->formatData($response, $request);
    }

    /**
     * @param Response $response
     * @param Request|null $request
     * @return \Illuminate\Http\Response | String
     */
    public function globalResponse(Response $response, Request $request = null)
    {
        return $this->formatData($response, $request);
    }
}
