<?php

class Model_OrderToStaff extends PhalApi_Model_NotORM {

    protected function getTableName($id) {
        return 'jfy_order_staff';
    }
}