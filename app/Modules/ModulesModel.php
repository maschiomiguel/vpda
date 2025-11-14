<?php

namespace App\Modules;

use App\Traits\Attachable;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Orchid\Screen\AsSource;

class ModulesModel extends Model
{
    use HasFactory, Attachable, AsSource;

    public $activeColumn = true;
    public $orderColumn = true;
    public $hasSlug = false;
    public $generateUniqueSlug = true;

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        array_push($this->fillable, 'title');

        if ($this->activeColumn) {
            array_push($this->fillable, 'active');
        }
        if ($this->orderColumn) {
            array_push($this->fillable, 'order');
        }
    }

    protected static function boot()
    {
        parent::boot();
        static::saving(function (ModulesModel $model) {
            if ($model->hasSlug) {
                $model->setSlugAutomatic();
            }
            return $model;
        });
    }

    public function setSlugAutomatic()
    {
        // if(!empty($this->slug)) {
        // return;
        // }

        if (!empty($this->title)) {
            $slug_source = $this->title;
        } else if (!empty($this->name)) {
            $slug_source = $this->name;
        } else {
            $slug_source = Str::random(24);
        }
        $slug = Str::slug($slug_source);

        if ($this->generateUniqueSlug) {

            $i = 0;
            $sufix = '';

            while (true) {

                $slugExists = $this->select('id')
                    ->where('id', '!=', $this->id ?: -1)
                    ->where('slug', "$slug$sufix")
                    ->count() > 0;

                if (!$slugExists) {
                    break;
                }

                $i++;
                $sufix = "-$i";
            }

            $slug = "$slug$sufix";
        }

        $this->slug = $slug;
    }

    /**
     * Verifica se algum input único teve seu valor alterado, caso encontre algum arquivo que foi alterado, 
     * remove o arquivo que foi alterado do banco e da pasta public.
     */
    public function checkForModificationAndUnlink($requestData)
    {
        if ($this->exists && $this->attachments) {
            foreach ($this->attachments as $field => $attribute) {
                $relationship = Str::camel($attribute);
                if ($this->$field !== $requestData[$field]) {
                    //Deleta arquivo que foi modificado (antigo)
                    $this->unlinkSingleAttachment($relationship);
                }
            };
        }
    }

    /**
     * Sincroniza attachments multiplos, que vem do input: Upload
     * @param array $requestData - Array com os dados do request
     */
    public function syncMultipleAttachments($requestData)
    {
        if (!empty($requestData['attachment'])) {
            foreach ($requestData['attachment'] as $attachment) {
                $this->attachment()->syncWithoutDetaching(
                    $attachment,
                    []
                );
            }
        }
    }

    /**
     * Sincroniza attachments únicos, que vem dos inputs: Cropper e Picture
     * @param array $requestData - Array com os dados do request
     */
    public function syncSingleAttachments($requestData)
    {
        if ($this->attachments) {
            foreach ($this->attachments as $field => $attribute) {
                if (array_key_exists($field, $requestData)) {
                    $attachment_in_camel = Str::camel($attribute);
                    // Verifica se a relação existe
                    if (method_exists($this, $attachment_in_camel)) {
                        if ($this->$attachment_in_camel->table === "attachments") {
                            $this->attachment()->syncWithoutDetaching(
                                $requestData[$field]
                            );
                        }
                    }
                }
            };
        } else {
            return false;
        }
    }

    /**
     * Remove do banco e da pasta public um attachment único.
     */
    private function unlinkSingleAttachment($attachment)
    {
        $this->$attachment->delete();
        $this->$attachment()->delete();
    }

    /**
     * Remove do banco e da pasta public todos attachments.
     */
    private function unlinkMultipleAttachments()
    {
        $this->attachment->each->delete();
    }

    public function unlinkAllAttachments()
    {
        if ($this->attachments) {
            foreach ($this->attachments as $field => $attribute) {
                $relationship = Str::camel($attribute);
                // Verifica se a relação existe
                if (method_exists($this, $relationship)) {
                    if ($this->$relationship->table === "attachments") {
                        $this->unlinkSingleAttachment($relationship);
                    }
                }
            };
        }
        $this->unlinkMultipleAttachments();
    }

    protected function syncPivotTable($requestData)
    {
        if ($this->sync) {
            foreach ($this->sync as $field => $attribute) {
                $relationship = $attribute;
                // Verifica se a relação existe
                if (method_exists($this, $relationship)) {
                    if (array_key_exists($field, $requestData)) {
                        if (empty($requestData[$field])) {
                            $this->$relationship()->detach();
                        }
                        $this->$relationship()->sync($requestData[$field], $this->id);
                    }
                }
            };
        }
    }

    protected function unsyncPivotTable()
    {
        if ($this->sync) {
            foreach ($this->sync as $field => $attribute) {
                $relationship = $attribute;
                if (method_exists($this, $relationship)) {
                    $this->$relationship()->detach();
                }
            };
        }
    }


    public function checkAndSave($requestData)
    {
        $this->checkForModificationAndUnlink($requestData);

        $this->fill($requestData);
        $this->save();

        $this->syncPivotTable($requestData);

        $this->syncSingleAttachments($requestData);
        $this->syncMultipleAttachments($requestData);
        return true;
    }

    public function unlinkAndDelete()
    {
        $this->unsyncPivotTable();
        $this->unlinkAllAttachments();
        $this->delete();
    }

    public function getAttachment($tipo)
    {
        return $this->attachment->filter(fn ($a) => $a->group === $tipo)->flatten();
    }

    public function hasAttachment($tipo)
    {
        return ($this->attachment->filter(fn ($a) => $a->group === $tipo)->count() > 0) ? true : false;
    }

    public function getLogName()
    {
        return $this->name;
    }

    public static function getEntityNameSingular()
    {
        return 'item';
    }

    public static function getEntityNamePlural()
    {
        return 'itens';
    }

    public static function getArticle()
    {
        return 'o';
    }

    public function canDelete($count = false)
    {
        return true;
    }
}
