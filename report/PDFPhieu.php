<?php
    require('fpdf/tfpdf.php');
    class PDF_MySQL_Table extends tFPDF
	    {
	    protected $ProcessingTable=false;
	    protected $aCols=array();
	    protected $TableX;
	    protected $HeaderColor;
	    protected $RowColors;
	    protected $ColorIndex;
		// Page footer
		function Footer()
		{
		    // Position at 1.5 cm from bottom
		    $this->SetY(-15);
		    // Arial italic 8
		    $this->SetFont('Arial','I',8);
		    // Page number
		    $this->Cell(0,10,'Page '.$this->PageNo(),0,0,'C');
		}

	    function Header()
	    {
	        // Print the table header if necessary
	        if($this->ProcessingTable)
	            $this->TableHeader();
	    }

	    function TableHeader()
	    {
	    	$this->AddFont('DejaVu','','DejaVuSansCondensed.ttf',true);
    		$this->SetFont('DejaVu','',10);
	        $this->SetX($this->TableX);
	        $fill=!empty($this->HeaderColor);
	        if($fill)
	            $this->SetFillColor($this->HeaderColor[0],$this->HeaderColor[1],$this->HeaderColor[2]);
	        foreach($this->aCols as $col)
	            $this->Cell($col['w'],6,$col['c'],1,0,'C',$fill);
	        $this->Ln();
	    }

	    function Row($data)
	    {
	        $this->SetX($this->TableX);
	        $ci=$this->ColorIndex;
	        $fill=!empty($this->RowColors[$ci]);
	        if($fill)
	            $this->SetFillColor($this->RowColors[$ci][0],$this->RowColors[$ci][1],$this->RowColors[$ci][2]);
	        foreach($this->aCols as $col)
	            $this->Cell($col['w'],5,$data[$col['f']],1,0,$col['a'],$fill);
	        $this->Ln();
	        $this->ColorIndex=1-$ci;
	    }

	    function CalcWidths($width, $align)
	    {
	        // Compute the widths of the columns
	        $TableWidth=0;
	        foreach($this->aCols as $i=>$col)
	        {
	            $w=$col['w'];
	            if($w==-1)
	                $w=$width/count($this->aCols);
	            elseif(substr($w,-1)=='%')
	                $w=$w/100*$width;
	            $this->aCols[$i]['w']=$w;
	            $TableWidth+=$w;
	        }
	        // Compute the abscissa of the table
	        if($align=='C')
	            $this->TableX=max(($this->w-$TableWidth)/2,0);
	        elseif($align=='R')
	            $this->TableX=max($this->w-$this->rMargin-$TableWidth,0);
	        else
	            $this->TableX=$this->lMargin;
	    }

	    function AddCol($field=-1, $width=-1, $caption='', $align='L')
	    {
	        // Add a column to the table
	        if($field==-1)
	            $field=count($this->aCols);
	        $this->aCols[]=array('f'=>$field,'c'=>$caption,'w'=>$width,'a'=>$align);
	    }

	    function Table($res, $prop=array())
	    {
	        // Add all columns if none was specified
	        if(count($this->aCols)==0)
	        {
	            $nb=8;
	            for($i=0;$i<$nb;$i++)
	                $this->AddCol();
	        }
	        // Retrieve column names when not specified
	        foreach($this->aCols as $i=>$col)
	        {
	            if($col['c']=='')
	            {
	                // if(is_string($col['f']))
	                //     $this->aCols[$i]['c']=ucfirst($col['f']);
	                // else
	                //     $this->aCols[$i]['c']=ucfirst(mysqli_fetch_field_direct($res,$col['f'])->name);
					$this->aCols[$i]['c']=ucfirst($col['f']);
	            }
	        }
	        // Handle properties
	        if(!isset($prop['width']))
	            $prop['width']=0;
	        if($prop['width']==0)
	            $prop['width']=$this->w-$this->lMargin-$this->rMargin;
	        if(!isset($prop['align']))
	            $prop['align']='C';
	        if(!isset($prop['padding']))
	            $prop['padding']=$this->cMargin;
	        $cMargin=$this->cMargin;
	        $this->cMargin=$prop['padding'];
	        if(!isset($prop['HeaderColor']))
	            $prop['HeaderColor']=array();
	        $this->HeaderColor=$prop['HeaderColor'];
	        if(!isset($prop['color1']))
	            $prop['color1']=array();
	        if(!isset($prop['color2']))
	            $prop['color2']=array();
	        $this->RowColors=array($prop['color1'],$prop['color2']);
	        // Compute column widths
	        $this->CalcWidths($prop['width'],$prop['align']);
	        // Print header
	        $this->TableHeader();
	        // Print rows
	        // $this->SetFont('Arial','',11);
	        $this->AddFont('DejaVu','','DejaVuSansCondensed.ttf',true);
    		$this->SetFont('DejaVu','',10);
	        $this->ColorIndex=0;
	        $this->ProcessingTable=true;
			foreach($res as $key => $row) {
				$this->Row($row);
			}
	        // while($row=mysqli_fetch_array($res)){
	        //     $this->Row($row);
	        // }
	        $currentDay = "Ngày ".date("d"). " Tháng ".date("m")." Năm ".date("Y");
	        $this->Cell(0,10,$currentDay,0,0,'R');
	        $this->Ln();
	        $this->Cell(0,10,'Ký tên               ',0,0,'R');
	        $this->ProcessingTable=false;
	        $this->cMargin=$cMargin;
	        $this->aCols=array();
	    }
	}
?>