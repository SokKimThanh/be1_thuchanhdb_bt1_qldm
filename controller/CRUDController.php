<?php

/**
 * Sok Kim Thanh 22211tt0063 01/11/2023 8:33 SA
 * Interface: CRUD Controller
 */
interface CRUDController
{
    public function getList()/* : array */;
    public function Add($object)/* : void */;
    public function Edit($object)/* : void */;
    public function DeleteById($id)/* : void */;
    public function FindById($id)/* : object */;
}
