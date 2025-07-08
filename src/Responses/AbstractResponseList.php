<?php
/**
 * Author: galih
 * Date: 2019-05-19
 * Time: 22:33
 */

namespace WebAppId\SmartResponse\Responses;

/**
 * @author: Dyan Galih<dyan.galih@gmail.com>
 * Date: 26/04/20
 * Time: 13.49
 * Class AbstractResponse
 * @package WebAppId\SmartResponse\Responses
 */
abstract class AbstractResponseList extends AbstractResponse
{
    public int $count;
    public int $countFiltered;
}
