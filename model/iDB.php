<?php
interface iDB
{

    public function SelectAll();
    public function SelectOne($id);
    public function Insert($object);
    public function Update($object);
    public function Delete($id);
}
