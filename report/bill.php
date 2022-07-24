<?php
    require('PDFPhieu.php');

    class PDF extends PDF_MySQL_Table
    {
        function Header()
        {
            // Title
            $this->AddFont('DejaVu','','DejaVuSansCondensed.ttf',true);
            $this->SetFont('DejaVu','',18);
            $this->Cell(0,6,'Hóa đơn dịch vụ',0,1,'C');
            $this->SetFont('DejaVu','',13);
            $this->Ln(10);
            // Ensure table header is printed
            parent::Header();
        }
    }

    // Connect to database
    include('../connection.php');
    $id = $_GET['id'];
    
    $row = (array) callAPI("GET", $id);

    $pdf = new PDF();
    $pdf->AddPage();
    $pdf->Cell(0,10,'Mã hóa đơn '.$row['id'],0,0,'L');
    $pdf->Ln();
    $pdf->Cell(0,10,'Bàn '.$_GET['table'],0,0,'L');
    $pdf->Ln();
    $pdf->Cell(80,10,'Tên món',1,0,'C');
    $pdf->Cell(30,10,'Đơn giá',1,0,'C');
    $pdf->Cell(30,10,'Số lượng',1,0,'C');
    $pdf->Cell(50,10,'Tổng giá',1,0,'C');
    $pdf->Ln();
    $items = (array) $row['items'];
    foreach($items as $keyItem => $item) {
        $item = (array) $item;
        if($item['status'] == 2) {
            $count = $item['count'];
            $total = $count * $item['price'];
            $pdf->Cell(80,10,$item['name'],1,0,'C');
            $pdf->Cell(30,10,formatPrice($item['price']),1,0,'C');
            $pdf->Cell(30,10,$count.'',1,0,'C');
            $pdf->Cell(50,10,formatPrice($total),1,0,'C');
            $pdf->Ln();
        }
    }
    $pdf->Ln();
    $currentDay = "Ngày ".date("d"). " Tháng ".date("m")." Năm ".date("Y");
	$pdf->Cell(0,10,$currentDay,0,0,'R');
	$pdf->Ln();
	$pdf->Cell(0,10,'Ký tên                  ',0,0,'R');
    $pdf->Output();
    
?>