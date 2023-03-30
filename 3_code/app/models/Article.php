<?php

// Namespace
namespace App\Models;

// Load Capsule
use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Eloquent\Model;

class Article extends Model {
    // Parameters
    protected $table = "article";
    public $timestamps = false;

    protected $primaryKey = "idArticle";
    protected $fillable = ["idArticle", "title", "creationDate", "updateDate", "banner", "summary", "content", "idArticleStatus", "idMember"];

    // Getter
    public function getIdArticle() {
        return $this->idArticle;
    }

    public function getTitle() {
        return $this->title;
    }

    public function getCreationDate() {
        return $this->creationDate;
    }

    public function getUpdateDate() {
        return $this->updateDate;
    }

    public function getBanner() {
        return $this->banner;
    }

    public function getSummary() {
        return $this->summary;
    }

    public function getContent() {
        return $this->content;
    }

    public function getIdArticleStatus() {
        return $this->idArticleStatus;
    }

    public function getIdMember() {
        return $this->idMember;
    }

    // Setter
    public function setTitle($title) {
        $this->title = $title;
        return $this;
    }

    public function setCreationDate($creationDate) {
        $this->creationDate = $creationDate;
        return $this;
    }

    public function setUpdateDate($updateDate) {
        $this->updateDate = $updateDate;
        return $this;
    }

    public function setBanner($banner) {
        $this->banner = $banner;
        return $this;
    }

    public function setSummary($summary) {
        $this->summary = $summary;
        return $this;
    }

    public function setContent($content) {
        $this->content = $content;
        return $this;
    }

    public function setIdArticleStatus($idArticleStatus) {
        $this->idArticleStatus = $idArticleStatus;
        return $this;
    }

    public function setIdMember($idMember) {
        $this->idMember = $idMember;
        return $this;
    }
}