<?php

namespace App\Controllers;

use App\Framework\Controller;
use App\Services\MaterialService;

class MaterialController extends Controller {
    private $materialService;

    public function __construct() {
        parent::__construct();
        $this->materialService = new MaterialService();
    }

    public function addMaterial() {
        $user = $this->getUserFromJwt();
        $data = $this->getRequestData();
        $result = $this->materialService->addMaterial((object)$data);
        if ($result) {
            $this->respond(['success' => true, 'material' => $result]);
        } else {
            $this->respondWithError(500, "Failed to add material");
        }
    }

    public function editMaterial($id) {
        $user = $this->getUserFromJwt();
        $data = $this->getRequestData();
        $data->id = $id;
        $result = $this->materialService->editMaterial($data);
        if ($result) {
            $this->respond(['success' => true]);
        } else {
            $this->respondWithError(500, "Failed to update material");
        }
    }

    public function deleteMaterial($id) {
        $user = $this->getUserFromJwt();
        $result = $this->materialService->deleteMaterial($id);
        if ($result) {
            $this->respond(['success' => true]);
        } else {
            $this->respondWithError(500, "Failed to delete material");
        }
    }

    public function getMaterialById($id) {
        //$user = $this->getUserFromJwt();
        $material = $this->materialService->getMaterialById($id);
        if ($material) {
            $this->respond($material);
        } else {
            $this->respondWithError(404, "Material not found");
        }
    }

    public function getMaterialByCity($city) {
        // $user = $this->getUserFromJwt();
        $materials = $this->materialService->getMaterialByCity($city);
        $this->respond($materials);
    }

    public function getAllMaterials() {
        $materials = $this->materialService->getAllMaterials();
        $this->respond($materials);
    }

    public function getHighestStockMaterial() {
        // $user = $this->getUserFromJwt();
        $material = $this->materialService->getHighestStockMaterial();
        $this->respond($material);
    }

    public function getAllQuantities() {
        // $user = $this->getUserFromJwt();
        $quantities = $this->materialService->getAllQuantities();
        $this->respond($quantities);
    }
}