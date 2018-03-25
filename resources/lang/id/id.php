<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

    return [
    
        //title
        'login_title' =>'Halaman Masuk',
        'main_title' => 'Halaman Produk',
        'profile_title' => 'Profil',
        'logout_title' => 'Keluar',
        'transaction_title' => 'Transaksi',
        'report_title' => 'Laporan',
        'cashier_title' => 'Kasir',
        'users_title' => 'Kelola User',
        
        
        //login
        'login_header_text' => 'Silahkan Masuk',
        'username_text' => 'ID Kasir',
        'password_text' => 'Sandi',
        'login_button_text' => 'Masuk',
        
        //product
        'view_text'=>'Lihat',
        'tools_text'=>'Peralatan',
        'edit_text'=>'Ubah',
        'delete_text'=>'Hapus',
        'search_product_text'=>'Masukkan keyword produk ...',
        'filter_according_to_text'=>'Urutkan berdasarkan',
        'max_stock_text' => 'Stok Tertinggi',
        'min_stock_text' => 'Stok Terendah',
        'max_price_text' => 'Harga Tertinggi',
        'min_price_text' => 'Harga Terendah',
        
        //transaction
        
        //user
        'users_list_text' => 'Daftar Pengguna',
        'create_form_title_text' => 'Form Tambah Pengguna',
        'edit_form_title_text' => 'Form Ubah Pengguna',
        'edit_form_change_password_text' => 'Form Ubah Sandi Pengguna',
        'phone_text' => 'Nomor Telepon',
        'address_text' => 'Alamat',
        'role_text' => 'Role',
        'role_options_text' => [
          '0' => 'ADMIN',
          '1' => 'KASIR'  
        ],
        'confirm_password_text' => 'Konfirmasi Sandi',
        'form_user_create_text' => 'Tambahkan',
        'form_user_edit_text' => 'Ubah',
        'old_password_text'=>'Sandi Lama',
        
        //message
        'username_not_found_msg' => 'ID KASIR TIDAK DITEMUKAN, SILAHKAN UNTUK MENCOBA LAGI.',
        'password_not_matched_msg' => 'SANDI YANG ANDA MASUKKAN TIDAK SESUAI, SILAHKAN UNTUK MENCOBA LAGI.',
        'end_session_msg' => 'SESSION ANDA TELAH BERAKHIR, SILAHKAN LOGIN KEMBALI UNTUK DAPAT MENGAKSES '.env('APP_NAME'),
        'out_of_stock_msg' => 'ITEM KOSONG',
        'back_msg' => 'Apakah anda yakin akan membatalkan pengisian/pengubahan data?',
        'delete_msg' => 'Apakah anda yakin akan menghapus data ini? ',
        'success_inserted_msg' => 'Data berhasil dimasukkan.',
        'success_updated_msg' => 'Data berhasil diubah.',
        'success_fetch_data' => 'Data berhasil di fetch.',
        'success_deleted_data' => 'Data berhasil dihapus.',
        'internal_error_msg' => 'Internal Error.',
        'danger_own_user_deleted_msg' => 'Anda tidak dapat menghapus data anda sendiri.',
        'old_password_not_validated_msg' => 'The :attribute field is not validated.',
        
        //general
        'cancel_text' => 'Batalkan',
        'delete_text' => 'Hapus',
        'understand_text' => 'Mengerti',
        'back_text'=> 'Kembali',
        'confirmation_text' => 'Konfirmasi'
        
    ];


