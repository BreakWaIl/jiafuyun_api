<?php
/**
 * 默认接口服务类
 *
 * @author: Dm
 */
class Api_Company_Information_Update extends PhalApi_Api {

    public function getRules() {
        return array (
            'Go' => array(
                'userId' => array('name' => 'user_id', 'type' => 'int', 'min' => 1, 'require' => true, 'desc' => '服务商ID'),
                'telephone' => array('name' => 'telephone', 'type' => 'string', 'min'=> 1, 'require' => true, 'desc' => '公司电话'),
                'legalPerson' => array('name' => 'legal_person', 'type' => 'string', 'min'=> 1, 'require' => true, 'desc' => '法人名称'),
                'mobile' => array('name' => 'mobile', 'type' => 'string', 'min'=> 1, 'require' => true, 'desc' => '手机号'),
                'intermediaryFee' => array('name' => 'intermediary_fee', 'type' => 'array', 'format'=>'json', 'require' => true, 'desc' => '中介费'),
                'teacherNumber' => array('name' => 'teacher_number', 'type' => 'int', 'min' => 1, 'require' => true, 'desc' => '老师数量'),
                'staffNumber' => array('name' => 'staff_number', 'type' => 'int', 'min' => 1, 'require' => true, 'desc' => '家政员数量'),
                'business' => array('name' => 'business', 'type' => 'array', 'format'=>'json', 'require' => true, 'desc' => '经营项目'),
                'partWorkCharge' => array('name' => 'part_work_charge', 'type' => 'string', 'min' => 1, 'require' => true, 'desc' => '钟点工收费标准'),
                'isIntermediaryFee' => array('name' => 'is_intermediary_fee', 'type'=>'array','format' => 'json', 'require'=> true,'desc'=> '钟点工是否有中介费'),
                'isCleaning' => array('name' => 'is_cleaning', 'type'=>'enum','range' => array('y','n'), 'default' => 'n', 'require'=> true,'desc'=> '是否做开荒保洁:y 是 n 否'),
                'charges' => array('name' => 'charges', 'type' => 'string', 'min' => 1, 'require' => true, 'desc' => '收费标准'),
                'introduction' => array('name' => 'introduction', 'type' => 'string', 'min'=> 1, 'require' => true, 'desc' => '公司简介'),
                'zipCode' => array('name' => 'zip_code', 'type' => 'int', 'min' => 0, 'require' => false, 'desc' => '邮编'),
                'remark' => array('name' => 'remark', 'type' => 'string', 'require' => false, 'desc' => '备注'),
            ),
        );
    }


    /**
     * 更新服务商资料
     * #desc 用于更新服务商资料
     * #return int code 操作码，0表示成功
     * #return int user_id 服务商ID
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

        $data = array(
            'user_id' => $this->userId,
            'telephone' => $this->telephone,
            'legal_person' => $this->legalPerson,
            'mobile' => $this->mobile,
            'intermediary_fee' => json_encode($this->intermediaryFee),
            'teacher_number' => $this->teacherNumber,
            'staff_number' => $this->staffNumber,
            'business' => json_encode($this->business),
            'part_work_charge' => $this->partWorkCharge,
            'is_intermediary_fee' => json_encode($this->isIntermediaryFee),
            'is_cleaning' => $this->isCleaning,
            'charges' => $this->charges,
            'introduction' => $this->introduction,
            'zip_code' => $this->zipCode,
            'remark' => $this->remark,
        );

        try {
            DI ()->notorm->beginTransaction ( 'db_api' );
            $companyInformationDomain = new Domain_Company_Information();
            $companyInformationDomain->update($data);
            DI ()->notorm->commit( 'db_api' );

        } catch ( Exception $e ) {

            DI ()->notorm->rollback ( 'db_api' );
            $rs ['code'] = $e->getCode ();
            $rs ['msg'] = $e->getMessage ();
        }

        $rs['info']['user_id'] = $this->userId;

        return $rs;
    }

}
