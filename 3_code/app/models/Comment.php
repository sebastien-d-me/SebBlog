<?php

/** Namespace */
namespace App\Models;

/** Load Capsule */
use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model {
    /** Parameters */
    protected $table = "comment";
    public $timestamps = false;

    protected $primaryKey = "idComment";
    protected $fillable = ["idComment", "content", "creationDate", "idMember", "idCommentStatus", "idArticle"];

    /** Getter */
    public function getIdComment() {
        return $this->idComment;
    }

    public function getContent() {
        return $this->content;
    }

    public function getCreationDate() {
        return $this->creationDate;
    }

    public function getMember() {
        return $this->idMember;
    }

    public function getIdCommentStatus() {
        return $this->idCommentStatus;
    }

    public function getIdArticle() {
        return $this->idArticle;
    }

    /** Setter */
    public function setContent($content) {
        $this->content = $content;
        return $this;
    }

    public function setCreationDate($creationDate) {
        $this->creationDate = $creationDate;
        return $this;
    }

    public function setIdMember($idMember) {
        $this->idMember = $idMember;
        return $this;
    }

    public function setIdCommentStatus($idCommentStatus) {
        $this->idCommentStatus = $idCommentStatus;
        return $this;
    }

    public function setIdArticle($idArticle) {
        $this->idArticle = $idArticle;
        return $this;
    }
}