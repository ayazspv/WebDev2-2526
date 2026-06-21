<?php

namespace App\Services;

use App\Services\IMaterialService;
use App\Repositories\MaterialRepository;

class MaterialService implements IMaterialService {
    private $materialRepository;

    public function __construct() {
        $this->materialRepository = new MaterialRepository();
    }

    public function addMaterial($material) {
        return $this->materialRepository->addMaterial($material);
    }

    public function editMaterial($material) {
        return $this->materialRepository->editMaterial($material);
    }

    public function deleteMaterial($id) {
        return $this->materialRepository->deleteMaterial($id);
    }

    public function getMaterialById($id) {
        return $this->materialRepository->getMaterialById($id);
    }

    public function getMaterialByCity($city) {
        return $this->materialRepository->getMaterialByCity($city);
    }

    public function getAllMaterials() {
        return $this->materialRepository->getAllMaterials();
    }

    public function getHighestStockMaterial() {
        return $this->materialRepository->getHighestStockMaterial();
    }

    public function getAllQuantities() {
        return $this->materialRepository->getAllQuantities();
    }
}