<?php
class prosesCrud
{

    protected $db;
    function __construct($db)
    {
        $this->db = $db;
    }

    function proses_login($user, $pass)
    {
        $row = $this->db->prepare('SELECT * FROM akun_penyedia WHERE username=? AND password=?');
        $row->execute(array($user, $pass));
        $count = $row->rowCount();
        if ($count > 0) {
            return $hasil = $row->fetch();
        } else {
            return 'gagal';
        }
    }

    function proses_login_admin($user, $pass)
    {
        $row = $this->db->prepare('SELECT * FROM operator WHERE username=? AND password=?');
        $row->execute(array($user, $pass));
        $count = $row->rowCount();
        if ($count > 0) {
            return $hasil = $row->fetch();
        } else {
            return 'gagal';
        }
    }

    // variable $tabel adalah isi dari nama table database yang ingin ditampilkan

    function tampil_data_saja($select, $tabel, $where)
    {
        $row = $this->db->prepare("SELECT $select FROM $tabel WHERE $where");
        $row->execute();
        return $hasil = $row->fetch();
    }

    function tampil_data($tabel)
    {
        $row = $this->db->prepare("SELECT * FROM $tabel");
        $row->execute();
        return $hasil = $row->fetchAll();
    }

    function tampil_data_select($select, $tabel, $where)
    {
        $row = $this->db->prepare("SELECT $select FROM $tabel WHERE $where");
        $row->execute();
        return $hasil = $row->fetchAll();
    }

    function tampil_data_join2($select, $tabel1, $tabel2, $join, $where)
    {
        $row = $this->db->prepare("SELECT $select FROM $tabel1 a LEFT JOIN $tabel2 b ON a.$join = b.$join WHERE $where");
        $row->execute();
        return $hasil = $row->fetchAll();
    }

    function tampil_data_saja_join2($select, $tabel1, $tabel2, $join, $where)
    {
        $row = $this->db->prepare("SELECT $select FROM $tabel1 a LEFT JOIN $tabel2 b ON a.$join = b.$join WHERE $where");
        $row->execute();
        return $hasil = $row->fetch();
    }

    function cek_data_saja_join2($select, $tabel1, $tabel2, $join, $where)
    {
        $row = $this->db->prepare("SELECT $select FROM $tabel1 a LEFT JOIN $tabel2 b ON a.$join = b.$join WHERE $where");
        $row->execute();
        return $hasil = $row->rowCount();
    }

    // variable $tabel adalah isi dari nama table database yang ingin ditampilkan
    // variable where adalah isi kolom tabel yang mau diambil
    // variable id adalah id yang mau di ambil

    function tampil_where($tabel, $where1, $id1, $where2, $id2)
    {
        $row = $this->db->prepare("SELECT * FROM $tabel WHERE $where1 = '$id1' AND $where2 = '$id2'");
        $row->execute();
        return $hasil = $row->fetch();
    }

    function tampil_data_id($tabel, $where, $id)
    {
        $row = $this->db->prepare("SELECT * FROM $tabel WHERE $where = ?");
        $row->execute(array($id));
        return $hasil = $row->fetch();
    }

    function cek($tabel, $id)
    {
        $row = $this->db->prepare("SELECT * FROM $tabel WHERE jawaban IS NULL AND id_pengguna=?");
        $row->execute(array($id));
        return $hasil = $row->rowCount();
    }

    function cek_row($tabel, $where)
    {
        $row = $this->db->prepare("SELECT * FROM $tabel WHERE $where");
        $row->execute();
        return $hasil = $row->rowCount();
    }

    function cek_fetch($tabel, $where)
    {
        $row = $this->db->prepare("SELECT * FROM $tabel WHERE $where");
        $row->execute();
        return $hasil = $row->fetch();
    }

    function cek_count($tabel, $where)
    {
        $row = $this->db->prepare("SELECT * FROM $tabel WHERE $where");
        $row->execute();
        return $hasil = $row->rowCount();
    }

    function cek_count_join2($select, $tabel1, $tabel2, $join1, $where)
    {
        $row = $this->db->prepare("SELECT $select FROM $tabel1 a LEFT JOIN $tabel2 b ON a.$join1 = b.$join1 WHERE $where");
        $row->execute();
        return $hasil = $row->rowCount();
    }

    function cek_pengguna($select, $tabel, $where)
    {
        $row = $this->db->prepare("SELECT $select FROM $tabel WHERE $where");
        $row->execute();
        return $hasil = $row->fetch();
    }

    function update_log($tabel, $set, $value, $where)
    {
        $row = $this->db->prepare("UPDATE $tabel SET $set = $set + $value WHERE $where");
        $row->execute();
    }

    function update_biasa($tabel, $set, $value, $where)
    {
        $row = $this->db->prepare("UPDATE $tabel SET $set = $value  WHERE $where");
        $row->execute();
    }

    function tambah_data($tabel, $data)
    {
        // buat array untuk isi values insert sumber kode 
        // http://thisinterestsme.com/pdo-prepared-multi-inserts/
        $rowsSQL = array();
        // buat bind param Prepared Statement
        $toBind = array();
        // list nama kolom
        $columnNames = array_keys($data[0]);
        // looping untuk mengambil isi dari kolom / values
        foreach ($data as $arrayIndex => $row) {
            $params = array();
            foreach ($row as $columnName => $columnValue) {
                $param = ":" . $columnName . $arrayIndex;
                $params[] = $param;
                $toBind[$param] = $columnValue;
            }
            $rowsSQL[] = "(" . implode(", ", $params) . ")";
        }
        $sql = "INSERT INTO $tabel (" . implode(", ", $columnNames) . ") VALUES " . implode(", ", $rowsSQL);
        $row = $this->db->prepare($sql);
        //Bind our values.
        foreach ($toBind as $param => $val) {
            $row->bindValue($param, $val);
        }
        //Execute our statement (i.e. insert the data).
        $row->execute();

        return $lastid  = $this->db->lastInsertId();
    }

    function edit_data($tabel, $data, $where, $id)
    {
        // sumber kode 
        // https://stackoverflow.com/questions/23019219/creating-generic-update-function-using-php-mysql
        $setPart = array();
        foreach ($data as $key => $value) {
            $setPart[] = $key . "=:" . $key;
        }
        $sql = "UPDATE $tabel SET " . implode(', ', $setPart) . " WHERE $where = :id";
        $row = $this->db->prepare($sql);
        //Bind our values.
        $row->bindValue(':id', $id); // where
        foreach ($data as $param => $val) {
            $row->bindValue($param, $val);
        }
        return $row->execute();
    }

    function edit_data_where($tabel, $data, $where1, $id1, $where2, $id2, $where3, $id3)
    {
        // sumber kode 
        // https://stackoverflow.com/questions/23019219/creating-generic-update-function-using-php-mysql
        $setPart = array();
        foreach ($data as $key => $value) {
            $setPart[] = $key . "=:" . $key;
        }
        $sql = "UPDATE $tabel SET " . implode(', ', $setPart) . " WHERE $where1 = :id1 AND $where2 = :id2 AND $where3 = :id3";
        $row = $this->db->prepare($sql);
        //Bind our values.
        $row->bindValue(':id1', $id1); // where
        $row->bindValue(':id2', $id2); // and
        $row->bindValue(':id3', $id3); // and
        foreach ($data as $param => $val) {
            $row->bindValue($param, $val);
        }
        return $row->execute();
    }

    function hapus_data($tabel, $where, $id)
    {
        $sql = "DELETE FROM $tabel WHERE $where = ?";
        $row = $this->db->prepare($sql);
        return $row->execute(array($id));
    }
}
