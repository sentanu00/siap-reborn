# simpg-sap
Install Server Windows
1. siapkan webservice terlebih dahulu (XAMPP,LAMPP)
2. selanjutnya download git
3. setting git untuk checkout ke folder htdocs anda dengan link github https://github.com/dirg-bisma/simpg-sap.git  
   exp. c:/xampp/htdocs/simpg

4. setelah itu create database bisa via phpmyadmin
5. jalankan dari browser [ip-server]/simpg
6. ikuti dan isi instruksi hingga selesai

Instalasi Server Linux

1. konek ke ssh server 
2. setelah itu masuk sudo dengan cara
   $sudo su
   masukan password user 

3. cek git --version
4. jika tidak ada install dengan perintah
   apt-get update
   apt-get install git

5. jika proses no 3 berhasil coba lakukan no 2
6. jika berhasil maka akan muncul informasi versi dari git yang digunakan

7. seteleh itu clone project github ke folder /var/www dengan mengetikan 
   #cd /var/www/
   #git clone https://github.com/dirg-bisma/simpg-sap.git simpg

8. tunggu hingga proses selesai
9. setelah itu ganti permission group nya menjadi www-data 
   #chown -R www-data:www-data /var/www/simpg/
   #chown -R www-data:www-data /var/www/simpg/.git
   #chown -R www-data:www-data /var/www/simpg/*

10. ganti www-data menjadi sudo dengan edit
    nano /etc/sudoers
    tambah baris di bawah ini setelah root ALL=(ALL:ALL) ALL
    git ALL=(www-data) ALL 

11. setelah itu buat database nya di server 
    dengan ketik
    # mysql -u [username] -p [password]
    mysql> create database [namadatabase];

12. jalankan dari browser [ip-server]/simpg
13. ikuti dan isi instruksi hingga selesai
