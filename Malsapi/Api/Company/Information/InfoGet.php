<?php
/**
 * 默认接口服务类
 *
 * @author: Dm
 */
class Api_Company_Information_InfoGet extends PhalApi_Api {
    
    public function getRules() {
        return array (
                 'Go' => array(
                     'userId' => array('name' => 'user_id', 'type' => 'int', 'min' => 1, 'require' => true, 'desc' => '服务商ID'),
            ),
        );
    }
  
  /**
     * 获取服务商资料详情
     * #desc 用于获取服务商资料表详情
     * #return int code 操作码，0表示成功
     * #return int id 资料表ID
     * #return int user_id 服务商ID
     * #return string telephone 公司电话
     * #return string legal_person 法人代表
     * #return string mobile 手机号
     * #return array intermediary_fee 中介费
     * #return int teacher_number 老师数量
     * #return int staff_number 家政员数量
     * #return array business 经营项目
     * #return string part_work_charge 钟点工收费标准
     * #return string is_intermediary_fee 钟点是否有中介费:y 是 n 否
     * #return string is_cleaning 是否做开荒保洁:y 是 n 否
     * #return string charges 收费标准
     * #return string introduction 公司简介
     * #return string zip_code 邮编
     * #return string remark 备注
     * #return int create_time 创建时间
     * #return int last_modify  最后更新时间
     * #return string company_name 公司名称
     * #return string address 公司地址
  */
    public function Go() {
        $rs = array('code' => 0, 'msg' => '', 'info' => array());

        //判断服务商是否存在
        $domain = new Domain_Company_User();
        $userInfo = $domain->getBaseInfo($this->userId);
        if(empty($userInfo)){
            DI()->logger->debug('User not found', $this->userId);

            $rs['code'] = 106;
            $rs['msg'] = T('User not exists');
            return $rs;
        }

        $companyInformationDomain = new Domain_Company_Information();
        $info = $companyInformationDomain->getBaseInfo($this->userId);

        $rs['info'] = $info;

        return $rs;
    }
    
}
