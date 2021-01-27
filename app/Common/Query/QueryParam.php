<?php
/**
 * Created by shaofeng
 * Date: 2020/12/11 14:17
 */

namespace App\Common\Query;


use App\Common\Constant\OrderType;

class QueryParam
{
    private $orderColumn='id';

    private $pageSize=20;

    private $pageNo=1;

    private $where=[];

    private $orderType=OrderType::ASC;

    /**
     * @return mixed
     */
    public function getOrderColumn()
    {
        return $this->orderColumn;
    }

    /**
     * @param mixed $orderColumn
     */
    public function setOrderColumn($orderColumn): void
    {
        $this->orderColumn = $orderColumn;
    }

    /**
     * @return mixed
     */
    public function getPageNo():int
    {
        return $this->pageNo;
    }

    /**
     * @param mixed $pageNo
     */
    public function setPageNo($pageNo): void
    {
        $this->pageNo = $pageNo;
    }



    /**
     * @return mixed
     */
    public function getWhere():array
    {
        return $this->where;
    }

    /**
     * @param mixed $where
     */
    public function setWhere($where): void
    {
        $this->where = $where;
    }

    /**
     * @return int
     */
    public function getPageSize(): int
    {
        return $this->pageSize;
    }

    /**
     * @param int $pageSize
     */
    public function setPageSize(int $pageSize): void
    {
        $this->pageSize = $pageSize;
    }

    /**
     * @return mixed
     */
    public function getOrderType()
    {
        return $this->orderType;
    }

    /**
     * @param mixed $orderType
     */
    public function setOrderType($orderType): void
    {
        $this->orderType = $orderType;
    }


}