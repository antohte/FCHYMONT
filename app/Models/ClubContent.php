<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClubContent extends Model
{
    protected $fillable = ['kind', 'source_key', 'data', 'is_published', 'sort_order'];

    protected function casts(): array
    {
        return ['data' => 'array', 'is_published' => 'boolean', 'sort_order' => 'integer'];
    }

    public function editorData(): array
    {
        $data = $this->data;
        if (in_array($this->kind, ['contacts', 'social']) && ! array_key_exists('entries', $data)) {
            $data['entries'] = [];
            if ($this->kind === 'contacts') {
                foreach ([1, 2] as $i) {
                    if (! empty($data['contact'.$i.'_phone'])) {
                        $data['entries'][] = ['name' => $data['contact'.$i.'_name'] ?? '', 'phone' => $data['contact'.$i.'_phone']];
                    }
                }
            } else {
                foreach (['instagram' => 'Instagram', 'facebook' => 'Facebook'] as $key => $name) {
                    if (! empty($data[$key.'_url'])) {
                        $data['entries'][] = ['name' => $name, 'account' => $data[$key.'_account'] ?? '', 'url' => $data[$key.'_url']];
                    }
                }
            }
        }
        if ($this->kind === 'news' && empty($data['date']) && preg_match('/([0-9]{4})/', $data['month'] ?? '', $year)) {
            $months = ['janvier', 'février', 'mars', 'avril', 'mai', 'juin', 'juillet', 'août', 'septembre', 'octobre', 'novembre', 'décembre'];
            $month = array_search(explode(' ', trim($data['month']))[0], $months, true);
            if ($month !== false) {
                $date = sprintf('%s-%02d-%02d', $year[1], $month + 1, (int) ($data['day'] ?? 0));
                if (checkdate($month + 1, (int) ($data['day'] ?? 0), (int) $year[1])) {
                    $data['date'] = $date;
                }
            }
        }

        return $data;
    }

    public function publicData(): array
    {
        return array_merge($this->data, ['id' => (string) $this->id]);
    }
}
