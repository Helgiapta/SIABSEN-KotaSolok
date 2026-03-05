<?php

namespace App\Exports;

use App\Models\Anggota;
use App\Models\LogAbsensi;
use App\Models\StatusManual;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\FromArray;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use Carbon\Carbon;

class AbsensiExport implements FromArray, WithTitle, WithEvents
{
    protected string $dateStart;
    protected string $dateEnd;
    protected ?int   $anggotaId;

    // Baris mana header dan data (diset saat array() dibangun)
    protected int $rowTitle    = 1;
    protected int $rowPeriode  = 2;
    protected int $rowHeader   = 3; // langsung header, tanpa baris kosong
    protected int $rowDataStart = 4;
    protected int $rowDataEnd   = 4;
    protected int $totalCols    = 2;

    const STATUS_MAP = [
        'Hadir Penuh'    => 'H',
        'Hadir Setengah' => '½',
        'Izin'           => 'I',
        'Sakit'          => 'S',
        'Tidak Hadir'    => 'A',
    ];

    const STATUS_COLORS = [
        'H'  => ['bg' => 'DCFCE7', 'fg' => '166534'],
        '½'  => ['bg' => 'FEF9C3', 'fg' => '854D0E'],
        'I'  => ['bg' => 'EDE9FE', 'fg' => '6B21A8'],
        'S'  => ['bg' => 'CCFBF1', 'fg' => '0F766E'],
        'A'  => ['bg' => 'FEE2E2', 'fg' => '991B1B'],
    ];

    public function __construct(string $dateStart, string $dateEnd, ?int $anggotaId = null)
    {
        $this->dateStart = $dateStart;
        $this->dateEnd   = $dateEnd;
        $this->anggotaId = $anggotaId;
    }

    public function title(): string
    {
        return 'Rekap Absensi';
    }

    public function array(): array
    {
        // Ambil anggota
        $anggotaQuery = Anggota::where('status_aktif', 1);
        if ($this->anggotaId) {
            $anggotaQuery->where('id', $this->anggotaId);
        }
        $semuaAnggota = $anggotaQuery->orderBy('nama')->get();

        // Build range tanggal
        $start    = Carbon::parse($this->dateStart);
        $end      = Carbon::parse($this->dateEnd);
        $tanggals = [];
        for ($d = $start->copy(); $d->lte($end); $d->addDay()) {
            $tanggals[] = $d->format('Y-m-d');
        }

        $numDays         = count($tanggals);
        $this->totalCols = 2 + $numDays + 4; // No + Nama + days + 4 totals

        // Ambil log & status manual
        $logsRaw = LogAbsensi::whereBetween('tanggal', [$this->dateStart, $this->dateEnd])
            ->when($this->anggotaId, fn($q) => $q->where('anggota_id', $this->anggotaId))
            ->get()
            ->groupBy(fn($l) => $l->anggota_id . '_' . $l->tanggal);

        $statusManuals = StatusManual::whereBetween('tanggal', [$this->dateStart, $this->dateEnd])
            ->when($this->anggotaId, fn($q) => $q->where('anggota_id', $this->anggotaId))
            ->get()
            ->keyBy(fn($s) => $s->anggota_id . '_' . $s->tanggal);

        $empty = array_fill(0, $this->totalCols, '');
        $rows  = [];

        // Row 1: Judul
        $bulan  = $start->locale('id')->translatedFormat('F Y');
        $row1   = $empty;
        $row1[0] = 'REKAP ABSENSI – ' . strtoupper($bulan);
        $rows[] = $row1;

        // Row 2: Periode
        $row2   = $empty;
        $row2[0] = 'Periode: ' . $start->locale('id')->translatedFormat('d F Y') . ' s/d ' . $end->locale('id')->translatedFormat('d F Y');
        $rows[] = $row2;

        // Row 3: Header
        $header = ['No.', 'Nama Anggota'];
        foreach ($tanggals as $tgl) {
            $header[] = (int) Carbon::parse($tgl)->format('j');
        }
        $header[] = 'Total H';
        $header[] = 'Izin';
        $header[] = 'Sakit';
        $header[] = 'Tdk Hadir';
        $rows[] = $header;

        // Row 4+: Data anggota
        $this->rowDataStart = 4;
        $no = 1;
        foreach ($semuaAnggota as $anggota) {
            $row = [$no++, $anggota->nama];
            $totalH = $totalI = $totalS = $totalA = 0;

            foreach ($tanggals as $tgl) {
                $key          = $anggota->id . '_' . $tgl;
                $logs         = $logsRaw->get($key, collect());
                $logMasuk     = $logs->where('tipe_absen', 'Datang')->first();
                $logPulang    = $logs->where('tipe_absen', 'Pulang')->first();
                $statusManual = $statusManuals->get($key);

                if ($statusManual) {
                    $status = $statusManual->status;
                } elseif ($logMasuk && $logPulang) {
                    $status = 'Hadir Penuh';
                } elseif ($logMasuk) {
                    $status = 'Hadir Setengah';
                } else {
                    $status = 'Tidak Hadir';
                }

                $code = self::STATUS_MAP[$status] ?? 'A';
                $row[] = $code;

                match ($code) {
                    'H', '½' => $totalH++,
                    'I'      => $totalI++,
                    'S'      => $totalS++,
                    default  => $totalA++,
                };
            }

            $row[] = $totalH;
            $row[] = $totalI;
            $row[] = $totalS;
            $row[] = $totalA;
            $rows[] = $row;
        }

        $this->rowDataEnd = 3 + $semuaAnggota->count();

        // Baris keterangan (pakai kolom A saja, isi string)
        $ket   = $empty;
        $ket[0] = 'Keterangan:  H = Hadir Penuh  |  ½ = Hadir Setengah  |  I = Izin  |  S = Sakit  |  A = Tidak Hadir';
        $rows[] = $ket;

        return $rows;
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet     = $event->sheet->getDelegate();
                $lastColL  = $this->colLetter($this->totalCols);
                $headerRow = $this->rowHeader;   // 3
                $dataStart = $this->rowDataStart; // 4
                $dataEnd   = $this->rowDataEnd;  // 3 + n
                $ketRow    = $dataEnd + 1;

                // ── Font global Times New Roman 12 ──────────────────────
                $sheet->getParent()->getDefaultStyle()->getFont()
                    ->setName('Times New Roman')->setSize(12);

                // ── Row 1: Judul ────────────────────────────────────────
                $sheet->mergeCells("A1:{$lastColL}1");
                $sheet->getStyle('A1')->applyFromArray([
                    'font'      => ['bold' => true, 'size' => 14, 'name' => 'Times New Roman', 'color' => ['rgb' => 'FFFFFF']],
                    'fill'      => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '0F4C75']],
                    'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER],
                ]);
                $sheet->getRowDimension(1)->setRowHeight(32);

                // ── Row 2: Periode ──────────────────────────────────────
                $sheet->mergeCells("A2:{$lastColL}2");
                $sheet->getStyle('A2')->applyFromArray([
                    'font'      => ['italic' => true, 'size' => 11, 'name' => 'Times New Roman', 'color' => ['rgb' => '475569']],
                    'fill'      => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'F1F5F9']],
                    'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
                ]);
                $sheet->getRowDimension(2)->setRowHeight(20);

                // ── Row 3: Header kolom ────────────────────────────────
                $sheet->getStyle("A{$headerRow}:{$lastColL}{$headerRow}")->applyFromArray([
                    'font'      => ['bold' => true, 'size' => 12, 'name' => 'Times New Roman', 'color' => ['rgb' => 'FFFFFF']],
                    'fill'      => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '1E3A5F']],
                    'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER],
                ]);
                $sheet->getRowDimension($headerRow)->setRowHeight(22);

                // ── Lebar kolom ─────────────────────────────────────────
                $sheet->getColumnDimension('A')->setWidth(6);
                $sheet->getColumnDimension('B')->setWidth(28);
                $numDays = $this->totalCols - 6; // totalCols - (No+Nama+4xTotal)
                for ($c = 3; $c <= 2 + $numDays; $c++) {
                    $sheet->getColumnDimension($this->colLetter($c))->setWidth(4.5);
                }
                for ($c = 3 + $numDays; $c <= $this->totalCols; $c++) {
                    $sheet->getColumnDimension($this->colLetter($c))->setWidth(10);
                }

                // ── Baris data ─────────────────────────────────────────
                for ($row = $dataStart; $row <= $dataEnd; $row++) {
                    $bg = ($row % 2 === 0) ? 'F8FAFC' : 'FFFFFF';
                    // No + Nama
                    $sheet->getStyle("A{$row}:B{$row}")->applyFromArray([
                        'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => $bg]],
                        'font' => ['name' => 'Times New Roman', 'size' => 12],
                    ]);
                    $sheet->getStyle("A{$row}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

                    // Sel tanggal — warna per kode status
                    for ($c = 3; $c <= 2 + $numDays; $c++) {
                        $colL   = $this->colLetter($c);
                        $code   = $sheet->getCell("{$colL}{$row}")->getValue();
                        $colors = self::STATUS_COLORS[$code] ?? ['bg' => $bg, 'fg' => '64748B'];
                        $sheet->getStyle("{$colL}{$row}")->applyFromArray([
                            'fill'      => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => $colors['bg']]],
                            'font'      => ['bold' => true, 'size' => 11, 'name' => 'Times New Roman', 'color' => ['rgb' => $colors['fg']]],
                            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
                        ]);
                    }

                    // Kolom total — center bold
                    for ($c = 3 + $numDays; $c <= $this->totalCols; $c++) {
                        $sheet->getStyle($this->colLetter($c) . $row)->applyFromArray([
                            'font'      => ['bold' => true, 'size' => 12, 'name' => 'Times New Roman'],
                            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
                        ]);
                    }

                    $sheet->getRowDimension($row)->setRowHeight(18);
                }

                // ── Border tabel ────────────────────────────────────────
                if ($dataEnd >= $dataStart) {
                    $sheet->getStyle("A{$headerRow}:{$lastColL}{$dataEnd}")->applyFromArray([
                        'borders' => [
                            'allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['rgb' => 'CBD5E1']],
                        ],
                    ]);
                }

                // ── Baris keterangan ────────────────────────────────────
                $sheet->mergeCells("A{$ketRow}:{$lastColL}{$ketRow}");
                $sheet->getStyle("A{$ketRow}")->applyFromArray([
                    'font'      => ['italic' => true, 'size' => 11, 'name' => 'Times New Roman', 'color' => ['rgb' => '64748B']],
                    'alignment' => ['horizontal' => Alignment::HORIZONTAL_LEFT],
                ]);
                $sheet->getRowDimension($ketRow)->setRowHeight(18);

                // ── Freeze pane — No+Nama tetap kelihatan saat scroll ──
                $sheet->freezePane('C4');
            },
        ];
    }

    private function colLetter(int $n): string
    {
        $letter = '';
        while ($n > 0) {
            $r      = ($n - 1) % 26;
            $letter = chr(65 + $r) . $letter;
            $n      = (int)(($n - 1) / 26);
        }
        return $letter;
    }

    public static function generateFilename(string $dateStart, string $dateEnd, ?string $namaAnggota = null): string
    {
        $start = Carbon::parse($dateStart);
        $end   = Carbon::parse($dateEnd);

        if ($namaAnggota) {
            $bulan = $start->locale('id')->translatedFormat('F Y');
            $nama  = str_replace(' ', '_', $namaAnggota);
            return "Absensi_{$nama}_{$bulan}.xlsx";
        }

        if ($start->format('Y-m') === $end->format('Y-m') && $start->day === 1 && $end->day === $end->daysInMonth) {
            return 'Rekap_Absensi_' . $start->locale('id')->translatedFormat('F Y') . '.xlsx';
        }

        $s = $start->format('d-m-Y');
        $e = $end->format('d-m-Y');
        return $s === $e ? "Rekap_Absensi_{$s}.xlsx" : "Rekap_Absensi_{$s}_sd_{$e}.xlsx";
    }
}
