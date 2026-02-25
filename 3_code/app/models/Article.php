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
    protected $fillable = ["idArticle", "title", "creationDate", "updateDate", "summary", "content", "idArticleStatus", "idMember"];

    // Getter
    public function getIdArticle(): int {
        return $this->idArticle;
    }

    public function getTitle(): string {
        return $this->title;
    }

    public function getCreationDate(): string {
        return $this->creationDate;
    }

    public function getUpdateDate(): string {
        return $this->updateDate;
    }

    public function getSummary(): string {
        return $this->summary;
    }

    public function getContent(): string {
        return $this->content;
    }

    public function getIdArticleStatus(): int {
        return $this->idArticleStatus;
    }

    public function getIdMember(): string {
        return $this->idMember;
    }

    // Setter
    public function setTitle(string $title): string {
        $this->title = $title;
        return $this;
    }

    public function setCreationDate(string $creationDate): string {
        $this->creationDate = $creationDate;
        return $this;
    }

    public function setUpdateDate(string $updateDate): string {
        $this->updateDate = $updateDate;
        return $this;
    }

    public function setSummary(string $summary): string {
        $this->summary = $summary;
        return $this;
    }

    public function setContent(string $content): string {
        $this->content = $content;
        return $this;
    }

    public function setIdArticleStatus(string $idArticleStatus): string {
        $this->idArticleStatus = $idArticleStatus;
        return $this->idArticleStatus;
    }

    public function setIdMember(string $idMember): string {
        $this->idMember = $idMember;
        return $this;
    }
}