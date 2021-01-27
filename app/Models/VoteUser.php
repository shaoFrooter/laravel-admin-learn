<?php
/**
 * Created by shaofeng
 * Date: 2020/12/31 16:11
 */

namespace App\Models;


use App\Common\Entity\VoteUserEntity;
use App\Common\Util\CommonUtil;

class VoteUser extends BaseModel
{
    protected $table = 'vote_user';
    protected $mappingPath = 'mapping/voteUser.php';

    public function selectByNickNameOrEmail($username, $email,$password)
    {
        if (CommonUtil::isEmpty($username) && CommonUtil::isEmpty($email)) {
            return null;
        }
        $queryBuilder = $this->newQuery();
        if (CommonUtil::isNotEmpty($username)) {
            $queryBuilder->where('nick_name', $username);
        }
        if (CommonUtil::isNotEmpty($email)) {
            $queryBuilder->where('email', $email);
        }
        if(CommonUtil::isNotEmpty($password)){
            $queryBuilder->where('password',$password);
        }
        $queryResult = $queryBuilder->get();
        if ($queryResult == null) {
            return null;
        }
        return $this->convert2Object($queryResult->toArray());
    }

    public function selectByNickNameAndEmail($username, $email)
    {
        if (CommonUtil::isEmpty($username) && CommonUtil::isEmpty($email)) {
            return null;
        }
        $queryBuilder = $this->newQuery();
        $queryResult = $queryBuilder->where('nick_name', $username)->where('email', $email)->get();
        return $this->convert2Object($queryResult->toArray());
    }

    public function selectByIdWithEntity($id){
        return $this->convert2Entity($this->selectById($id));
    }

    private function convert2Entity(array $dataArray)
    {
        $this->dbMapping();
        if (empty($dataArray)) {
            return null;
        }
        $entity = new VoteUserEntity();
        $entity->setId($dataArray['id']);
        $entity->setNickName($dataArray['nick_name']);
        $entity->setEmail($dataArray['email']);
        $entity->setPassword($dataArray['password']);
        $entity->setAvatar($dataArray['avatar']);
        $entity->setCreateTime($dataArray['create_time']);
        $entity->setUpdateTime($dataArray['update_time']);
        return $entity;
    }

}