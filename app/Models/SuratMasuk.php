<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use Zend\Debug\Debug;

class SuratMasuk extends Model
{

    public function getAll(array $p=[]){

        // Debug::dump(auth()->user()->role_id);die;

        $params = [];
        $sWhere = ($p['is_arsip']??0==1) ? " sm.is_arsip=1" : " sm.is_arsip is null";
        if (in_array(auth()->user()->role_id, [1,2,3,4])) { // admin, operator, ka opd, sekretaris

            if (in_array(auth()->user()->role_id, [2,3,4])){
                $params = [
                    'created_by' => auth()->id(),
                    'assign_to' => auth()->id(),
                ];
                $sWhere .= " and (sm.created_by = :created_by or sm.assign_to = :assign_to)";
            }

            $sql = "SELECT
                    sm.id,
                    sm.tanggal_surat,
                    sm.asal_surat,
                    sm.perihal_surat,
                    sm.nomor_surat,
                    case
                        when sm.jenis_surat_masuk = 0 then 'Biasa'
                        else 'Penting'
                    end as jenis_surat_masuk,
                    sm.id_operator,
                    sm.link_file,
                    sm.assign_to,
                    sm.is_disposisi,
                    sm.is_proses,
                    sm.is_arsip,
                    sm.is_deleted,
                    sm.created_at,
                    sm.created_by,
                    u.name as created_by_name,
                    u.nip as created_by_nip,
                    u.jabatan as created_by_jabatan
                from
                    surat_masuk sm
                left join users u on
                    sm.created_by = u.id
                where
                    {$sWhere}";
        } else {

            $params = [
                'target_disposisi' => auth()->id(),
            ];
            $sWhere .= " and dsm.target_disposisi = :target_disposisi";

            $sql = "SELECT 
                    sm.id,
                    sm.tanggal_surat,
                    sm.asal_surat,
                    sm.perihal_surat,
                    sm.nomor_surat,
                    case
                        when sm.jenis_surat_masuk = 0 then 'Biasa'
                        else 'Penting'
                    end as jenis_surat_masuk,
                    sm.id_operator,
                    sm.link_file,
                    sm.assign_to,
                    sm.is_disposisi,
                    sm.is_proses,
                    sm.is_arsip,
                    sm.is_deleted,
                    sm.created_at,
                    sm.created_by,
                    u.name as created_by_name,
                    u.nip as created_by_nip,
                    u.jabatan as created_by_jabatan
                from
                    disposisi_surat_masuk dsm
                join surat_masuk sm on
                    dsm.id_surat = sm.id
                left join users u on
                    sm.created_by = u.id
                where
                    {$sWhere}";

        }

        // Debug::dump($params);Debug::dump($sql);die();
                
        $data = app('db')->connection()->select($sql, $params);
        // Debug::dump($data);die;

        if ($data) {
            $User = new User();
            foreach ($data as $k => $v) {
                $data[$k]->assign_to = $User->getInfoById($v->assign_to);
                $data[$k]->disposisi = ($v->is_disposisi==1) ? $this->getDisposisiBySMId($v->id) : [];
                $data[$k]->pemroses = ($v->is_proses==1) ? $this->getProsesBySMId($v->id) : [];
            }
        }

        return $data;
    }

    public function getById(int $id=0){
        $sql = "SELECT
                sm.id,
                sm.tanggal_surat,
                sm.asal_surat,
                sm.perihal_surat,
                sm.nomor_surat,
                case
                    when sm.jenis_surat_masuk = 0 then 'Biasa'
                    else 'Penting'
                end as jenis_surat_masuk,
                sm.id_operator,
                sm.link_file,
                sm.assign_to,
                sm.is_disposisi,
                sm.is_proses,
                sm.is_arsip,
                sm.is_deleted,
                sm.created_at,
                sm.created_by,
                u.name as created_by_name,
                u.nip as created_by_nip,
                u.jabatan as created_by_jabatan,
                sm.updated_at
            from
                surat_masuk sm
            left join users u on
                sm.created_by = u.id
            where
                sm.id = :id";

        $data = app('db')->connection()->selectOne($sql, ['id'=>$id]);
        // Debug::dump($data);die;

        if ($data) {
            $User = new User();
            $data->assign_to = $User->getInfoById($data->assign_to);

        }

        return $data;
    }

    public function getDisposisiBySMId(int $id=0, $sort='DESC'){
        $sql = "SELECT
                dsm.id,
                dsm.source_disposisi,
                dsm.target_disposisi,
                dsm.created_at,
                dsm.keterangan
            from
                disposisi_surat_masuk dsm
            where
                id_surat = :id
            order by
                created_at {$sort}";
        // Debug::dump($sql);die;

        $data = app('db')->connection()->select($sql, ['id'=>$id]);
        // Debug::dump($data);die;

        if ($data) {
            $User = new User();
            foreach ($data as $k => $v) {
                $data[$k]->source_disposisi = $User->getInfoById($v->source_disposisi);
                $data[$k]->target_disposisi = $User->getInfoById($v->target_disposisi);
            }

        }

        return $data;
    }

    public function getProsesBySMId(int $id=0){
        $sql = "SELECT
                psm.id,
                psm.created_by,
                psm.created_at
            from
                proses_surat_masuk psm
            where
                psm.id_surat = :id";

        $data = app('db')->connection()->selectOne($sql, ['id'=>$id]);
        // Debug::dump($data);die;

    
        if ($data){
            $created_at = $data->created_at;
            $User = new User();
            $data = $User->getInfoById($data->created_by);
            $data->created_at = $created_at;
        }
        // Debug::dump($data);die;

        return $data;
    }

    public function getStatistik(){

        $params = [];
        $sWhere = "";
        if (in_array(auth()->user()->role_id, [1,2,3,4])) {

            if (in_array(auth()->user()->role_id, [2,3,4])){
                $params = [
                    'created_by' => auth()->id(),
                    'assign_to' => auth()->id(),
                ];
                $sWhere .= " and (sm.created_by = :created_by or sm.assign_to = :assign_to)";
            }

            $data = app('db')->connection()->selectOne("SELECT
                    sum(case when is_disposisi is null and is_proses is null and is_arsip is null then 1 else 0 end) surat_baru,
                    sum(case when is_disposisi = 1 and is_proses is null and is_arsip is null then 1 else 0 end) disposisi,
                    sum(case when is_proses = 1 and is_arsip is null then 1 else 0 end) proses,
                    sum(case when is_arsip = 1 then 1 else 0 end) arsip
                from
                    surat_masuk sm 
                where 1=1{$sWhere}", $params);
        } else {

            $params = [
                'target_disposisi' => auth()->id(),
            ];
            $sWhere .= " and dsm.target_disposisi = :target_disposisi";
            
            $data = app('db')->connection()->selectOne("SELECT
                    sum(case when sm.is_disposisi is null and sm.is_proses is null and sm.is_arsip is null then 1 else 0 end) surat_baru,
                    sum(case when sm.is_disposisi = 1 and sm.is_proses is null and sm.is_arsip is null then 1 else 0 end) disposisi,
                    sum(case when sm.is_proses = 1 and sm.is_arsip is null then 1 else 0 end) proses,
                    sum(case when sm.is_arsip = 1 then 1 else 0 end) arsip
                from
                    disposisi_surat_masuk dsm
                join surat_masuk sm on
                    dsm.id_surat = sm.id 
                where 1=1{$sWhere}", $params);
        }
        // Debug::dump($data);die;

        return $data;
    }

    public function getTrendline(){

        $params = [];
        $sWhere = "";
        if (in_array(auth()->user()->role_id, [1,2,3,4])) {

            if (in_array(auth()->user()->role_id, [2,3,4])){
                $params = [
                    'created_by' => auth()->id(),
                    'assign_to' => auth()->id(),
                ];
                $sWhere .= " and (sm.created_by = :created_by or sm.assign_to = :assign_to)";
            }

            $data = app('db')->connection()->select("SELECT
                    sm.tanggal_surat,
                    count(*) as jumlah
                from
                    surat_masuk sm
                where 1=1{$sWhere}
                group by
                    sm.tanggal_surat
                order by
                    sm.tanggal_surat", $params);
        } else {

            $params = [
                'target_disposisi' => auth()->id(),
            ];
            $sWhere .= " and dsm.target_disposisi = :target_disposisi";
            
            $data = app('db')->connection()->select("SELECT
                    sm.tanggal_surat,
                    count(*) as jumlah
                from
                    disposisi_surat_masuk dsm
                join surat_masuk sm on
                    dsm.id_surat = sm.id 
                where 1=1{$sWhere}
                group by
                    sm.tanggal_surat
                order by
                    sm.tanggal_surat", $params);
        }
        // Debug::dump($data);die;
        
        $trendline = [];
        foreach ($data as $k => $v) {
            $trendline[] = [
                strtotime($v->tanggal_surat)*1000,
                $v->jumlah
            ];
        }
        // Debug::dump($trendline);die;

        return $trendline;
    }
}
