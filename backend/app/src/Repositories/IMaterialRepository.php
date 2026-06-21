<?php

namespace App\Repositories;

interface IMaterialRepository
{
    public function addMAterial($material);
    public function editMaterial($material);
    public function deleteMaterial($id);
    public function getMaterialById($id);
    public function getMaterialByCity($city);
    public function getAllMaterials();
    public function getHighestStockMaterial();
    public function getAllQuantities();

}