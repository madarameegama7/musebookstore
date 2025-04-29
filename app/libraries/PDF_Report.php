<?php

/**
 * PDF_Report class
 * Extends FPDF with custom methods for report generation
 */
class PDF_Report extends FPDF
{
    /**
     * Calculate number of lines a MultiCell will use
     * 
     * @param float $width Width of cell
     * @param string $text Text to be measured
     * @return int Number of lines
     */
    function NbLines($width, $text)
    {
        // Calculate the number of lines this text will occupy in a cell with given width
        $cw = $this->CurrentFont['cw'];
        if ($width == 0) {
            $width = $this->w - $this->rMargin - $this->x;
        }

        $wmax = ($width - 2 * $this->cMargin) * 1000 / $this->FontSize;
        $s = str_replace("\r", '', $text);
        $nb = strlen($s);

        if ($nb > 0 && $s[$nb - 1] == "\n") {
            $nb--;
        }

        $sep = -1;
        $i = 0;
        $j = 0;
        $l = 0;
        $nl = 1;

        while ($i < $nb) {
            $c = $s[$i];
            if ($c == "\n") {
                $i++;
                $sep = -1;
                $j = $i;
                $l = 0;
                $nl++;
                continue;
            }

            if ($c == ' ') {
                $sep = $i;
            }

            $l += $cw[$c] ?? $this->CurrentFont['desc']['MissingWidth'] ?? 500;

            if ($l > $wmax) {
                if ($sep == -1) {
                    if ($i == $j) {
                        $i++;
                    }
                } else {
                    $i = $sep + 1;
                }
                $sep = -1;
                $j = $i;
                $l = 0;
                $nl++;
            } else {
                $i++;
            }
        }

        return $nl;
    }

    /**
     * Improved MultiCell with alignment
     * Allows formatting of cell contents with alignment
     * 
     * @param float $w Width of cell
     * @param float $h Height of cell
     * @param string $text Text to be displayed
     * @param mixed $border Border style (0, 1, L, T, R, B)
     * @param string $align Alignment (L, C, R, J)
     * @param boolean $fill Fill cell with background color
     */
    function ImprovedMultiCell($w, $h, $text, $border = 0, $align = 'J', $fill = false)
    {
        // Store starting position
        $x = $this->GetX();
        $y = $this->GetY();

        // Output the text
        $this->MultiCell($w, $h, $text, $border, $align, $fill);

        // Move to the right
        $this->SetXY($x + $w, $y);
    }

    /**
     * Write a row of data with proper alignment
     * 
     * @param array $data Array of cell data
     * @param float $cellWidth Width of each cell
     * @param float $cellHeight Height of each cell
     * @param string $border Border style
     * @param bool $fill Whether to fill the cell
     */
    function WriteRow($data, $cellWidth, $cellHeight, $border = 1, $fill = false)
    {
        $x = $this->GetX();
        $y = $this->GetY();
        $maxHeight = 0;

        // Calculate max height for this row
        foreach ($data as $cell) {
            // Handle arrays/nulls gracefully
            if (is_array($cell)) {
                $cellText = json_encode($cell);
            } elseif (is_object($cell)) {
                $cellText = json_encode($cell);
            } elseif (is_null($cell)) {
                $cellText = '';
            } else {
                $cellText = (string)$cell;
            }
            $lines = $this->NbLines($cellWidth, $cellText);
            $height = $lines * $cellHeight;
            if ($height > $maxHeight) {
                $maxHeight = $height;
            }
        }

        $colIndex = 0;
        // Write each cell
        $this->SetY($y);
        foreach ($data as $key => $cell) {
            if (is_array($cell)) {
                $cellText = json_encode($cell);
            } elseif (is_object($cell)) {
                $cellText = json_encode($cell);
            } elseif (is_null($cell)) {
                $cellText = '';
            } else {
                $cellText = (string)$cell;
            }
            $this->SetX($x + ($colIndex * $cellWidth));
            $rowHeight = ($maxHeight / max(1, $this->NbLines($cellWidth, $cellText)));
            $this->MultiCell($cellWidth, $rowHeight, $cellText, $border, 'L', $fill);

            $colIndex++;
        }

        // Move to next line
        $this->SetY($y + $maxHeight);
    }
}
