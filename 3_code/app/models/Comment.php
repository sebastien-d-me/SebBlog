<?php

// Namespace
namespace App\Models;

// Load Capsule
use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model {
    // Parameters
    protected $table = "comment";
    public $timestamps = false;

    protected $primaryKey = "idComment";
    protected $fillable = ["idComment", "content", "creationDate", "idMember", "idCommentStatus", "idArticle"];

    // Getter
    public function getIdComment(): int {
        return $this->idComment;
    }

    public function getContent(): string {
        return $this->content;
    }

    public function getCreationDate(): string {
        return $this->creationDate;
    }

    public function getIdMember(): string {
        return $this->idMember;
    }

    public function getIdCommentStatus(): int {
        return $this->idCommentStatus;
    }

    public function getIdArticle(): int {
        return $this->idArticle;
    }

    // Setter
    public function setContent(string $content): string {
        $this->content = $content;
        return $this;
    }

    public function setCreationDate(string $creationDate): string {
        $this->creationDate = $creationDate;
        return $this;
    }

    public function setIdMember(string $idMember): string {
        $this->idMember = $idMember;
        return $this;
    }

    public function setIdCommentStatus(string $idCommentStatus): string {
        $this->idCommentStatus = $idCommentStatus;
        return $this;
    }

    public function setIdArticle(string $idArticle): string {
        $this->idArticle = $idArticle;
        return $this;
    }
}