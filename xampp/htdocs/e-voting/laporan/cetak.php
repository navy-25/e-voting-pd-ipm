<?php
session_start();
include '../include/koneksi.php';
require("fpdf.php");
//memulai pengaturan output PDF
class PDF extends FPDF
{
//untuk pengaturan header halaman
	function Header()
	{
		$this->Image('awal.jpg',1.9,0.6,2.8,2.5);	
		$this->SetY(1);
		$this->SetFont('Times','',13);		
		$this->Cell(4,0.5,'',0,0,'L');				
		$this->Cell(15,0.5,'PANITIA PEMILIHAN',0,0,'L'); 		
		$this->Ln();
		$this->Cell(4,0.5,'',0,0,'L');				
		$this->Cell(15,0.5,'ANGGOTA PIMPINAN DAERAH IKATAN PELAJAR MUHAMMADIYAH KABUPATEN NGANJUK',0,0,'L');				
		$this->Ln();
		$this->Cell(4,0.5,'',0,0,'L');				
		$this->Cell(15,0.5,'PERIODE 2015 – 2017',0,0,'L');				
		$this->Ln();
		$this->Cell(4,0.5,'',0,0,'L');				
		$this->Cell(15,0.5,'Jl. Cipto Mangunkusumo no. 17 Kertosono',0,0,'L');				
		$this->Ln();
		$this->Cell(8,0.5,'==================================================================================================',0,0,'L');	
		$this->Ln();
	}
	function Footer()
	{
		$this->Ln();
		$this->SetY(-1.5);
		$this->SetFont('Arial','B',7);
		$this->Cell(0,0.3,$this->PageNo().'/{nb}',0,0,'R');
	}
}

//pengaturan ukuran kertas P = Portrait
$pdf = new PDF('P','cm','folio');
$pdf->Open();
$pdf->AliasNbPages();
$pdf->AddPage();

$jam1 = $_GET['jam1'];
$jam2 = $_GET['jam2'];

$pdf->Ln();
$pdf->SetFont('Arial','B',9);
$pdf->Cell(19,0.5,'No. 03 / BA / Panlih / PCM / 2016','',0,'C');
$pdf->Ln();
$pdf->SetFont('Arial','B',13);
$pdf->Cell(19,0.5,'BERITA ACARA HASIL PEMILIHAN','',0,'C');
$pdf->Ln();
$pdf->Cell(19,0.5,'PIMPINAN DAERAH IKATAN PELAJAR MUHAMMADIYAH KABUPATEN NGANJUK','',0,'C');
$pdf->Ln();
$pdf->Cell(19,0.5,'PERIODE 2017-2019','',0,'C');
$pdf->Ln();
$pdf->Image('bismillah.jpg',7.5,5.9,6.1,1.0);	
$pdf->Ln();
$pdf->Ln();
$pdf->Ln();
$pdf->SetFont('Times','',11);		
$pdf->MultiCell(0,0.5,'Pada hari ini Ahad tanggal 17 September 2017, pukul '.$jam1.' WIB sampai dengan '.$jam2.' WIB bertempat di Ranting SMK Muhammadiyah 1 Kertosono, telah dilaksanakan pemilihan Pimpinan Daerah Ikatan Pelajar Muhammadiyah Periode 2017-2019, dengan hasil sebagai berikut :',0,'J');


$total = 0;
$sqldua = "SELECT COUNT(DISTINCT a.pemilih_id) AS total FROM t_pemilihan A,m_pemilih b,m_ketetapan c
WHERE a.pemilih_id=b.pemilih_id AND b.ketetapan_id=c.ketetapan_id AND c.dewan_id='".$_SESSION['proses_pemilihan']."'";
$esqldua=mysql_query($sqldua);
while ($dsqldua = mysql_fetch_array ($esqldua)) {
	$total = $dsqldua['total'];
}

$sah = 0;
$sqldua = "SELECT COUNT(DISTINCT a.pemilih_id) AS total FROM t_pemilihan A,m_pemilih b,m_ketetapan c
WHERE a.pemilih_id=b.pemilih_id AND b.ketetapan_id=c.ketetapan_id AND c.dewan_id='".$_SESSION['proses_pemilihan']."' and a.calon_id <> '73'";
$esqldua=mysql_query($sqldua);
while ($dsqldua = mysql_fetch_array ($esqldua)) {
	$sah = $dsqldua['total'];
}

$abstain = 0;
$sqldua = "SELECT COUNT(DISTINCT a.pemilih_id) AS total FROM t_pemilihan A,m_pemilih b,m_ketetapan c
WHERE a.pemilih_id=b.pemilih_id AND b.ketetapan_id=c.ketetapan_id AND c.dewan_id='".$_SESSION['proses_pemilihan']."' and a.calon_id = '73'";
$esqldua=mysql_query($sqldua);
while ($dsqldua = mysql_fetch_array ($esqldua)) {
	$abstain = $dsqldua['total'];
}

$pdf->Ln();
$pdf->SetFont('Times','B',11);		
$pdf->Cell(0.5,0.5,'I','',0,'L');
$pdf->Cell(18,0.5,'Rekap Pemilihan','',0,'L');
$pdf->Ln();
$pdf->SetFont('Times','',11);		
$pdf->Cell(0.5,0.5,'','',0,'L');
$pdf->Cell(5,0.5,'Total pemilih','',0,'L');
$pdf->Cell(0.5,0.5,':','',0,'C');
$pdf->Cell(2,0.5,$total,'',0,'C');
$pdf->Cell(10,0.5,' Orang','',0,'L');
$pdf->Ln();
$pdf->Cell(0.5,0.5,'','',0,'L');
$pdf->Cell(5,0.5,'Jumlah Pemilih sah','',0,'L');
$pdf->Cell(0.5,0.5,':','',0,'C');
$pdf->Cell(2,0.5,$sah,'',0,'C');
$pdf->Cell(10,0.5,' Orang','',0,'L');
$pdf->Ln();
$pdf->Cell(0.5,0.5,'','',0,'L');
$pdf->Cell(5,0.5,'Jumlah abstain','',0,'L');
$pdf->Cell(0.5,0.5,':','',0,'C');
$pdf->Cell(2,0.5,$abstain,'',0,'C');
$pdf->Cell(10,0.5,' Orang','',0,'L');
$pdf->Ln();

$pdf->Ln();
$pdf->SetFont('Times','B',11);		
$pdf->Cell(0.5,0.5,'II','',0,'L');
$pdf->Cell(18,0.5,'Rekap Perolehan Suara','',0,'L');
$pdf->SetFont('Times','',11);		
$pdf->Cell(0.5,0.5,'','',0,'L');

$pdf->Ln();
$pdf->SetFont('Times','',11);		
$pdf->Cell(0.5,0.5,'','',0,'L');
$pdf->Cell(0.8,0.5,'NO','LBRT',0,'L');
$pdf->Cell(12,0.5,'NAMA','LBRT',0,'L');
$pdf->Cell(2,0.5,'NBM','LBRT',0,'C');
$pdf->Cell(4,0.5,'PEROLEHAN SUARA','LBRT',0,'L');
$pdf->Ln();



$sqlsatu	= "SELECT ketetapan_jumlah,ketetapan_id,ketetapan_calon FROM m_ketetapan where ketetapan_status='1' and dewan_id='".$_SESSION['proses_pemilihan']."'";
$esqlsatu	= mysql_query($sqlsatu);
$dsqlsatu	= mysql_fetch_array ($esqlsatu);
$awal		= $dsqlsatu[ketetapan_jumlah];
$tetap		= $dsqlsatu[ketetapan_id];
$calon		= $dsqlsatu[ketetapan_calon];
$limit = "limit 0,$awal";
$Qcekdata = "SELECT B.calon_urut,B.calon_nama,B.calon_NBM,(SELECT COUNT(*) FROM t_pemilihan WHERE calon_id=B.calon_id) AS nilai FROM m_calon B where B.calon_status='1' and ketetapan_id='$tetap' ORDER BY nilai DESC,calon_urut  $limit";
$Ecekdata = mysql_query($Qcekdata);
$a=1;
while($Dcekdata = mysql_fetch_array ($Ecekdata))
{
	$pdf->SetFont('Times','',10);		
	$pdf->Cell(0.5,0.5,'','',0,'L');
	$pdf->Cell(0.8,0.5,$a,'LBRT',0,'C');
	$pdf->Cell(12,0.5,$Dcekdata['calon_nama'],'LBRT',0,'L');
	$pdf->Cell(2,0.5,$Dcekdata['calon_NBM'],'LBRT',0,'C');
	$pdf->Cell(4,0.5,$Dcekdata['nilai'],'LBRT',0,'C');
	$pdf->Ln();
	$a++;
}


$pdf->Ln();
$pdf->SetFont('Times','B',11);		
$pdf->Cell(0.5,0.5,'III','',0,'L');
$pdf->Cell(18,0.5,' '.$calon.' Nama Pimpinan Daerah Ikatan Pelajar Muhammadiyah Kabupaten Nganjuk :','',0,'L');

$pdf->SetFont('Times','',11);		
$pdf->Cell(0.5,0.5,'','',0,'L');
$pdf->Ln();
$pdf->SetFont('Times','',11);		
$pdf->Cell(0.5,0.5,'','',0,'L');
$pdf->Cell(0.8,0.5,'NO','LBRT',0,'L');
$pdf->Cell(12,0.5,'NAMA','LBRT',0,'L');
$pdf->Cell(2,0.5,'NBM','LBRT',0,'C');
$pdf->Cell(4,0.5,'PEROLEHAN SUARA','LBRT',0,'L');
$pdf->Ln();



$limit2 = "limit 0,$calon";
$Qcekdata = "SELECT B.calon_urut,B.calon_nama,B.calon_NBM,(SELECT COUNT(*) FROM t_pemilihan WHERE calon_id=B.calon_id) AS nilai FROM m_calon B where B.calon_status='1' and ketetapan_id='$tetap' ORDER BY nilai DESC,calon_urut  $limit2";
$Ecekdata = mysql_query($Qcekdata);
$a=1;
while($Dcekdata = mysql_fetch_array ($Ecekdata))
{
	$pdf->SetFont('Times','',10);		
	$pdf->Cell(0.5,0.5,'','',0,'L');
	$pdf->Cell(0.8,0.5,$a,'LBRT',0,'C');
	$pdf->Cell(12,0.5,$Dcekdata['calon_nama'],'LBRT',0,'L');
	$pdf->Cell(2,0.5,$Dcekdata['calon_NBM'],'LBRT',0,'C');
	$pdf->Cell(4,0.5,$Dcekdata['nilai'],'LBRT',0,'C');
	$pdf->Ln();
	$a++;
}

$pdf->Ln();
$pdf->Cell(10.5,0.5,'','',0,'L');
$pdf->Cell(7,0.5,'Gresik, 19 Syawal 1437 H','',0,'R');
$pdf->Ln();
$pdf->Cell(10.5,0.5,'','',0,'L');
$pdf->Cell(7,0.5,'24  Juli  2016 M','',0,'R');
$pdf->Ln();


$pdf->Ln();
$pdf->SetFont('Times','B',11);		
$pdf->Cell(0.5,0.5,'','',0,'L');
$pdf->Cell(18,0.5,'Panitia Pemilihan :','',0,'L');
$pdf->Ln();
$pdf->SetFont('Times','',10);		
$pdf->Cell(0.5,0.8,'','',0,'L');
$pdf->Cell(3.5,0.8,'Ketua','',0,'L');
$pdf->Cell(0.5,0.8,':','',0,'C');
$pdf->Cell(8,0.8,'Fikriatunnisa Ramadhana','',0,'L');
$pdf->Cell(8,0.8,'...............................................................','',0,'L');


$pdf->Ln();
$pdf->Cell(0.5,0.8,'','',0,'L');
$pdf->Cell(3.5,0.8,'Sekretaris','',0,'L');
$pdf->Cell(0.5,0.8,':','',0,'C');
$pdf->Cell(8,0.8,'Novi Kartika Dewi','',0,'L');
$pdf->Cell(8,0.8,'...............................................................','',0,'L');



$pdf->Ln();
$pdf->Cell(0.5,0.8,'','',0,'L');
$pdf->Cell(3.5,0.8,'Anggota','',0,'L');
$pdf->Cell(0.5,0.8,':','',0,'C');
$pdf->Cell(8,0.8,'1. Moh Rizzy','',0,'L');
$pdf->Cell(8,0.8,'...............................................................','',0,'L');


$pdf->Ln();
$pdf->Cell(0.5,0.8,'','',0,'L');
$pdf->Cell(3.5,0.8,'','',0,'L');
$pdf->Cell(0.5,0.8,'','',0,'C');
$pdf->Cell(8,0.8,'2. Denika Mustika Sari','',0,'L');
$pdf->Cell(8,0.8,'...............................................................','',0,'L');

$pdf->Ln();
$pdf->Cell(0.5,0.8,'','',0,'L');
$pdf->Cell(3.5,0.8,'','',0,'L');
$pdf->Cell(0.5,0.8,'','',0,'C');
$pdf->Cell(8,0.8,'3. Siska Tri .W','',0,'L');
$pdf->Cell(8,0.8,'...............................................................','',0,'L');

$pdf->Ln();
$pdf->Cell(0.5,0.8,'','',0,'L');
$pdf->Cell(3.5,0.8,'Saksi','',0,'L');
$pdf->Cell(0.5,0.8,':','',0,'C');
$pdf->Cell(7,0.8,'1. ................................................................','',0,'L');
$pdf->Cell(5,0.8,'PD IPM. ............................................ ','',0,'L');
$pdf->Cell(3,0.8,'...............................','',0,'L');


$pdf->Ln();
$pdf->Cell(0.5,0.8,'','',0,'L');
$pdf->Cell(3.5,0.8,'','',0,'L');
$pdf->Cell(0.5,0.8,'','',0,'C');
$pdf->Cell(7,0.8,'2. ................................................................','',0,'L');
$pdf->Cell(5,0.8,'PD IPM. ............................................ ','',0,'L');
$pdf->Cell(3,0.8,'...............................','',0,'L');


$pdf->Ln();
$pdf->Cell(0.5,0.8,'','',0,'L');
$pdf->Cell(3.5,0.8,'','',0,'L');
$pdf->Cell(0.5,0.8,'','',0,'C');
$pdf->Cell(7,0.8,'3. ................................................................','',0,'L');
$pdf->Cell(5,0.8,'PC IPM. ............................................ ','',0,'L');
$pdf->Cell(3,0.8,'...............................','',0,'L');

$pdf->Ln();
$pdf->Cell(0.5,0.8,'','',0,'L');
$pdf->Cell(3.5,0.8,'','',0,'L');
$pdf->Cell(0.5,0.8,'','',0,'C');
$pdf->Cell(7,0.8,'4. ................................................................','',0,'L');
$pdf->Cell(5,0.8,'PC IPM. ............................................ ','',0,'L');
$pdf->Cell(3,0.8,'...............................','',0,'L');

$pdf->Ln();
$pdf->Cell(0.5,0.8,'','',0,'L');
$pdf->Cell(3.5,0.8,'','',0,'L');
$pdf->Cell(0.5,0.8,'','',0,'C');
$pdf->Cell(7,0.8,'5. ................................................................','',0,'L');
$pdf->Cell(5,0.8,'PR IPM. ............................................ ','',0,'L');
$pdf->Cell(3,0.8,'...............................','',0,'L');

$pdf->Ln();
$pdf->Cell(0.5,0.8,'','',0,'L');
$pdf->Cell(3.5,0.8,'','',0,'L');
$pdf->Cell(0.5,0.8,'','',0,'C');
$pdf->Cell(7,0.8,'6. ................................................................','',0,'L');
$pdf->Cell(5,0.8,'.................................................... ','',0,'L');
$pdf->Cell(3,0.8,'...............................','',0,'L');

$pdf->Ln();
$pdf->Cell(0.5,0.8,'','',0,'L');
$pdf->Cell(3.5,0.8,'','',0,'L');
$pdf->Cell(0.5,0.8,'','',0,'C');
$pdf->Cell(7,0.8,'7. ................................................................','',0,'L');
$pdf->Cell(5,0.8,'.................................................... ','',0,'L');
$pdf->Cell(3,0.8,'...............................','',0,'L');
//menampilkan output berupa halaman PDF
$pdf->Output();
?>