<?php

namespace BIPBOP\DocumentValidation;

class DocumentValidation {

    /**
     * Retorna objeto para validação de documentos
     * @return BIPBOP\DocumentValidation\DocumentValidation
     */
    public static function factory() {
        return new static;
    }

    protected function calculateModule11($numDado, $numDig, $limMult) {
        $dado = $numDado;

        for ($n = 1; $n <= $numDig; $n++) {
            $soma = 0;
            $mult = 2;
            for ($i = strlen($dado) - 1; $i >= 0; $i--) {
                $soma += $mult * intval(substr($dado, $i, 1));
                if (++$mult > $limMult)
                    $mult = 2;
            }
            $dado .= strval(fmod(fmod(($soma * 10), 11), 10));
        }

        return substr($dado, strlen($dado) - $numDig);
    }

    protected function assertSize($value, $size, $documento) {
        if (!in_array(strlen($value), (array) $size))
            throw new DocumentValidationException("$documento não possue o tamanho adequado");
    }

    public function calculateRenavam($string) {
        $string = str_pad($string, 9, "0", STR_PAD_LEFT);
        return $string . $this->calculateModule11($string, 2, 9);
    }

    public function assertCPF($string) {
        $string = preg_replace("/[^\d]/", "", $string);
        $this->assertSize($string, 11, "CPF");
        if ($this->calculateModule11(substr($string, 0, 9), 2, 12) != substr($string, 9, 2))
            throw new DocumentValidationException("O CPF não é válido");
        return $string;
    }

    public function assertCNPJ($string) {
        $string = preg_replace("/[^\d]/", "", $string);
        $this->assertSize($string, [14, 15], "CNPJ");
        $start = strlen($string) == 14 ? 12 : 13;
        if ($this->calculateModule11(substr($string, 0, $start), 2, 9) != substr($string, $start, 2))
            throw new DocumentValidationException("O CNPJ não é válido");
        return $string;
    }

    public function assertCPFCNPJ($string) {
        try {
            $this->assertCNPJ($string);
        } catch (DocumentValidationException $e) {
            $this->assertCPF($string);
        }

        return $string;
    }

    public function validateCPF($string) {
        try {
            $this->assertCPF($string);
        } catch (Exception $e) {
            return false;
        }
        return true;
    }

    public function validateCNPJ($string) {
        try {
            $this->assertCNPJ($string);
        } catch (Exception $e) {
            return false;
        }
        return true;
    }

    public function validateIncricaoEstadualAC($ie) {
        if (strlen($ie) != 13) {
            return 0;
        } else {
            if (substr($ie, 0, 2) != '01') {
                return 0;
            } else {
                $b = 4;
                $soma = 0;
                for ($i = 0; $i <= 10; $i++) {
                    $soma += $ie[$i] * $b;
                    $b--;
                    if ($b == 1) {
                        $b = 9;
                    }
                }
                $dig = 11 - ($soma % 11);
                if ($dig >= 10) {
                    $dig = 0;
                }
                if (!($dig == $ie[11])) {
                    return 0;
                } else {
                    $b = 5;
                    $soma = 0;
                    for ($i = 0; $i <= 11; $i++) {
                        $soma += $ie[$i] * $b;
                        $b--;
                        if ($b == 1) {
                            $b = 9;
                        }
                    }
                    $dig = 11 - ($soma % 11);
                    if ($dig >= 10) {
                        $dig = 0;
                    }

                    return ($dig == $ie[12]);
                }
            }
        }
    }

    public function validateIncricaoEstadualAL($ie) {
        if (strlen($ie) != 9) {
            return 0;
        } else {
            if (substr($ie, 0, 2) != '24') {
                return 0;
            } else {
                $b = 9;
                $soma = 0;
                for ($i = 0; $i <= 7; $i++) {
                    $soma += $ie[$i] * $b;
                    $b--;
                }
                $soma *= 10;
                $dig = $soma - ( ( (int) ($soma / 11) ) * 11 );
                if ($dig == 10) {
                    $dig = 0;
                }

                return ($dig == $ie[8]);
            }
        }
    }

    public function validateIncricaoEstadualAM($ie) {
        if (strlen($ie) != 9) {
            return 0;
        } else {
            $b = 9;
            $soma = 0;
            for ($i = 0; $i <= 7; $i++) {
                $soma += $ie[$i] * $b;
                $b--;
            }
            if ($soma <= 11) {
                $dig = 11 - $soma;
            } else {
                $r = $soma % 11;
                if ($r <= 1) {
                    $dig = 0;
                } else {
                    $dig = 11 - $r;
                }
            }

            return ($dig == $ie[8]);
        }
    }

    public function validateIncricaoEstadualAP($ie) {
        if (strlen($ie) != 9) {
            return 0;
        } else {
            if (substr($ie, 0, 2) != '03') {
                return 0;
            } else {
                $i = substr($ie, 0, -1);
                if (($i >= 3000001) && ($i <= 3017000)) {
                    $p = 5;
                    $d = 0;
                } elseif (($i >= 3017001) && ($i <= 3019022)) {
                    $p = 9;
                    $d = 1;
                } elseif ($i >= 3019023) {
                    $p = 0;
                    $d = 0;
                }

                $b = 9;
                $soma = $p;
                for ($i = 0; $i <= 7; $i++) {
                    $soma += $ie[$i] * $b;
                    $b--;
                }
                $dig = 11 - ($soma % 11);
                if ($dig == 10) {
                    $dig = 0;
                } elseif ($dig == 11) {
                    $dig = $d;
                }

                return ($dig == $ie[8]);
            }
        }
    }

    public function validateIncricaoEstadualBA($ie) {
        if (strlen($ie) != 8) {
            return 0;
        } else {

            $arr1 = array('0', '1', '2', '3', '4', '5', '8');
            $arr2 = array('6', '7', '9');

            $i = substr($ie, 0, 1);

            if (in_array($i, $arr1)) {
                $modulo = 10;
            } elseif (in_array($i, $arr2)) {
                $modulo = 11;
            }

            $b = 7;
            $soma = 0;
            for ($i = 0; $i <= 5; $i++) {
                $soma += $ie[$i] * $b;
                $b--;
            }

            $i = $soma % $modulo;
            if ($modulo == 10) {
                if ($i == 0) {
                    $dig = 0;
                } else {
                    $dig = $modulo - $i;
                }
            } else {
                if ($i <= 1) {
                    $dig = 0;
                } else {
                    $dig = $modulo - $i;
                }
            }
            if (!($dig == $ie[7])) {
                return 0;
            } else {
                $b = 8;
                $soma = 0;
                for ($i = 0; $i <= 5; $i++) {
                    $soma += $ie[$i] * $b;
                    $b--;
                }
                $soma += $ie[7] * 2;
                $i = $soma % $modulo;
                if ($modulo == 10) {
                    if ($i == 0) {
                        $dig = 0;
                    } else {
                        $dig = $modulo - $i;
                    }
                } else {
                    if ($i <= 1) {
                        $dig = 0;
                    } else {
                        $dig = $modulo - $i;
                    }
                }

                return ($dig == $ie[6]);
            }
        }
    }

    public function validateIncricaoEstadualCE($ie) {
        if (strlen($ie) != 9) {
            return 0;
        } else {
            $b = 9;
            $soma = 0;
            for ($i = 0; $i <= 7; $i++) {
                $soma += $ie[$i] * $b;
                $b--;
            }
            $dig = 11 - ($soma % 11);

            if ($dig >= 10) {
                $dig = 0;
            }

            return ($dig == $ie[8]);
        }
    }

    public function validateIncricaoEstadualDF($ie) {
        if (strlen($ie) != 13) {
            return 0;
        } else {
            if (substr($ie, 0, 2) != '07') {
                return 0;
            } else {
                $b = 4;
                $soma = 0;
                for ($i = 0; $i <= 10; $i++) {
                    $soma += $ie[$i] * $b;
                    $b--;
                    if ($b == 1) {
                        $b = 9;
                    }
                }
                $dig = 11 - ($soma % 11);
                if ($dig >= 10) {
                    $dig = 0;
                }

                if (!($dig == $ie[11])) {
                    return 0;
                } else {
                    $b = 5;
                    $soma = 0;
                    for ($i = 0; $i <= 11; $i++) {
                        $soma += $ie[$i] * $b;
                        $b--;
                        if ($b == 1) {
                            $b = 9;
                        }
                    }
                    $dig = 11 - ($soma % 11);
                    if ($dig >= 10) {
                        $dig = 0;
                    }

                    return ($dig == $ie[12]);
                }
            }
        }
    }

    public function validateIncricaoEstadualES($ie) {
        if (strlen($ie) != 9) {
            return 0;
        } else {
            $b = 9;
            $soma = 0;
            for ($i = 0; $i <= 7; $i++) {
                $soma += $ie[$i] * $b;
                $b--;
            }
            $i = $soma % 11;
            if ($i < 2) {
                $dig = 0;
            } else {
                $dig = 11 - $i;
            }

            return ($dig == $ie[8]);
        }
    }

    public function validateIncricaoEstadualGO($ie) {
        if (strlen($ie) != 9) {
            return 0;
        } else {
            $s = substr($ie, 0, 2);

            if (!( ($s == 10) || ($s == 11) || ($s == 15) )) {
                return 0;
            } else {
                $n = substr($ie, 0, 7);

                if ($n == 11094402) {
                    if ($ie[8] != 0) {
                        if ($ie[8] != 1) {
                            return 0;
                        } else {
                            return 1;
                        }
                    } else {
                        return 1;
                    }
                } else {
                    $b = 9;
                    $soma = 0;
                    for ($i = 0; $i <= 7; $i++) {
                        $soma += $ie[$i] * $b;
                        $b--;
                    }
                    $i = $soma % 11;
                    if ($i == 0) {
                        $dig = 0;
                    } else {
                        if ($i == 1) {
                            if (($n >= 10103105) && ($n <= 10119997)) {
                                $dig = 1;
                            } else {
                                $dig = 0;
                            }
                        } else {
                            $dig = 11 - $i;
                        }
                    }

                    return ($dig == $ie[8]);
                }
            }
        }
    }

    public function validateIncricaoEstadualMA($ie) {
        if (strlen($ie) != 9) {
            return 0;
        } else {
            if (substr($ie, 0, 2) != 12) {
                return 0;
            } else {
                $b = 9;
                $soma = 0;
                for ($i = 0; $i <= 7; $i++) {
                    $soma += $ie[$i] * $b;
                    $b--;
                }
                $i = $soma % 11;
                if ($i <= 1) {
                    $dig = 0;
                } else {
                    $dig = 11 - $i;
                }

                return ($dig == $ie[8]);
            }
        }
    }

    public function validateIncricaoEstadualMT($ie) {
        if (strlen($ie) != 11) {
            return 0;
        } else {
            $b = 3;
            $soma = 0;
            for ($i = 0; $i <= 9; $i++) {
                $soma += $ie[$i] * $b;
                $b--;
                if ($b == 1) {
                    $b = 9;
                }
            }
            $i = $soma % 11;
            if ($i <= 1) {
                $dig = 0;
            } else {
                $dig = 11 - $i;
            }

            return ($dig == $ie[10]);
        }
    }

    public function validateIncricaoEstadualMS($ie) {
        if (strlen($ie) != 9) {
            return 0;
        } else {
            if (substr($ie, 0, 2) != 28) {
                return 0;
            } else {
                $b = 9;
                $soma = 0;
                for ($i = 0; $i <= 7; $i++) {
                    $soma += $ie[$i] * $b;
                    $b--;
                }
                $i = $soma % 11;
                if ($i == 0) {
                    $dig = 0;
                } else {
                    $dig = 11 - $i;
                }

                if ($dig > 9) {
                    $dig = 0;
                }

                return ($dig == $ie[8]);
            }
        }
    }

    public function validateIncricaoEstadualMG($ie) {
        if (strlen($ie) != 13) {
            return 0;
        } else {
            $ie2 = substr($ie, 0, 3) . '0' . substr($ie, 3);

            $b = 1;
            $soma = "";
            for ($i = 0; $i <= 11; $i++) {
                $soma .= $ie2[$i] * $b;
                $b++;
                if ($b == 3) {
                    $b = 1;
                }
            }
            $s = 0;
            for ($i = 0; $i < strlen($soma); $i++) {
                $s += $soma[$i];
            }
            $i = substr($ie2, 9, 2);
            $dig = $i - $s;
            if ($dig != $ie[11]) {
                return 0;
            } else {
                $b = 3;
                $soma = 0;
                for ($i = 0; $i <= 11; $i++) {
                    $soma += $ie[$i] * $b;
                    $b--;
                    if ($b == 1) {
                        $b = 11;
                    }
                }
                $i = $soma % 11;
                if ($i < 2) {
                    $dig = 0;
                } else {
                    $dig = 11 - $i;
                };

                return ($dig == $ie[12]);
            }
        }
    }

    public function validateIncricaoEstadualPA($ie) {
        if (strlen($ie) != 9) {
            return 0;
        } else {
            if (substr($ie, 0, 2) != 15) {
                return 0;
            } else {
                $b = 9;
                $soma = 0;
                for ($i = 0; $i <= 7; $i++) {
                    $soma += $ie[$i] * $b;
                    $b--;
                }
                $i = $soma % 11;
                if ($i <= 1) {
                    $dig = 0;
                } else {
                    $dig = 11 - $i;
                }

                return ($dig == $ie[8]);
            }
        }
    }

    public function validateIncricaoEstadualPB($ie) {
        if (strlen($ie) != 9) {
            return 0;
        } else {
            $b = 9;
            $soma = 0;
            for ($i = 0; $i <= 7; $i++) {
                $soma += $ie[$i] * $b;
                $b--;
            }
            $i = $soma % 11;
            if ($i <= 1) {
                $dig = 0;
            } else {
                $dig = 11 - $i;
            }

            if ($dig > 9) {
                $dig = 0;
            }

            return ($dig == $ie[8]);
        }
    }

    public function validateIncricaoEstadualPR($ie) {
        if (strlen($ie) != 10) {
            return 0;
        } else {
            $b = 3;
            $soma = 0;
            for ($i = 0; $i <= 7; $i++) {
                $soma += $ie[$i] * $b;
                $b--;
                if ($b == 1) {
                    $b = 7;
                }
            }
            $i = $soma % 11;
            if ($i <= 1) {
                $dig = 0;
            } else {
                $dig = 11 - $i;
            }

            if (!($dig == $ie[8])) {
                return 0;
            } else {
                $b = 4;
                $soma = 0;
                for ($i = 0; $i <= 8; $i++) {
                    $soma += $ie[$i] * $b;
                    $b--;
                    if ($b == 1) {
                        $b = 7;
                    }
                }
                $i = $soma % 11;
                if ($i <= 1) {
                    $dig = 0;
                } else {
                    $dig = 11 - $i;
                }

                return ($dig == $ie[9]);
            }
        }
    }

    public function validateIncricaoEstadualPE($ie) {
        if (strlen($ie) == 9) {
            $b = 8;
            $soma = 0;
            for ($i = 0; $i <= 6; $i++) {
                $soma += $ie[$i] * $b;
                $b--;
            }
            $i = $soma % 11;
            if ($i <= 1) {
                $dig = 0;
            } else {
                $dig = 11 - $i;
            }

            if (!($dig == $ie[7])) {
                return 0;
            } else {
                $b = 9;
                $soma = 0;
                for ($i = 0; $i <= 7; $i++) {
                    $soma += $ie[$i] * $b;
                    $b--;
                }
                $i = $soma % 11;
                if ($i <= 1) {
                    $dig = 0;
                } else {
                    $dig = 11 - $i;
                }

                return ($dig == $ie[8]);
            }
        } elseif (strlen($ie) == 14) {
            $b = 5;
            $soma = 0;
            for ($i = 0; $i <= 12; $i++) {
                $soma += $ie[$i] * $b;
                $b--;
                if ($b == 0) {
                    $b = 9;
                }
            }
            $dig = 11 - ($soma % 11);
            if ($dig > 9) {
                $dig = $dig - 10;
            }

            return ($dig == $ie[13]);
        } else {
            return 0;
        }
    }

    public function validateIncricaoEstadualPI($ie) {
        if (strlen($ie) != 9) {
            return 0;
        } else {
            $b = 9;
            $soma = 0;
            for ($i = 0; $i <= 7; $i++) {
                $soma += $ie[$i] * $b;
                $b--;
            }
            $i = $soma % 11;
            if ($i <= 1) {
                $dig = 0;
            } else {
                $dig = 11 - $i;
            }
            if ($dig >= 10) {
                $dig = 0;
            }

            return ($dig == $ie[8]);
        }
    }

    public function validateIncricaoEstadualRJ($ie) {
        if (strlen($ie) != 8) {
            return 0;
        } else {
            $b = 2;
            $soma = 0;
            for ($i = 0; $i <= 6; $i++) {
                $soma += $ie[$i] * $b;
                $b--;
                if ($b == 1) {
                    $b = 7;
                }
            }
            $i = $soma % 11;
            if ($i <= 1) {
                $dig = 0;
            } else {
                $dig = 11 - $i;
            }

            return ($dig == $ie[7]);
        }
    }

    public function validateIncricaoEstadualRN($ie) {
        if (!( (strlen($ie) == 9) || (strlen($ie) == 10) )) {
            return 0;
        } else {
            $b = strlen($ie);
            if ($b == 9) {
                $s = 7;
            } else {
                $s = 8;
            }
            $soma = 0;
            for ($i = 0; $i <= $s; $i++) {
                $soma += $ie[$i] * $b;
                $b--;
            }
            $soma *= 10;
            $dig = $soma % 11;
            if ($dig == 10) {
                $dig = 0;
            }

            $s += 1;
            return ($dig == $ie[$s]);
        }
    }

    public function validateIncricaoEstadualRS($ie) {
        if (strlen($ie) != 10) {
            return 0;
        } else {
            $b = 2;
            $soma = 0;
            for ($i = 0; $i <= 8; $i++) {
                $soma += $ie[$i] * $b;
                $b--;
                if ($b == 1) {
                    $b = 9;
                }
            }
            $dig = 11 - ($soma % 11);
            if ($dig >= 10) {
                $dig = 0;
            }

            return ($dig == $ie[9]);
        }
    }

    public function validateIncricaoEstadualRO($ie) {
        if (strlen($ie) == 9) {
            $b = 6;
            $soma = 0;
            for ($i = 3; $i <= 7; $i++) {
                $soma += $ie[$i] * $b;
                $b--;
            }
            $dig = 11 - ($soma % 11);
            if ($dig >= 10) {
                $dig = $dig - 10;
            }

            return ($dig == $ie[8]);
        } elseif (strlen($ie) == 14) {
            $b = 6;
            $soma = 0;
            for ($i = 0; $i <= 12; $i++) {
                $soma += $ie[$i] * $b;
                $b--;
                if ($b == 1) {
                    $b = 9;
                }
            }
            $dig = 11 - ( $soma % 11);
            if ($dig > 9) {
                $dig = $dig - 10;
            }

            return ($dig == $ie[13]);
        } else {
            return 0;
        }
    }

    public function validateIncricaoEstadualRR($ie) {
        if (strlen($ie) != 9) {
            return 0;
        } else {
            if (substr($ie, 0, 2) != 24) {
                return 0;
            } else {
                $b = 1;
                $soma = 0;
                for ($i = 0; $i <= 7; $i++) {
                    $soma += $ie[$i] * $b;
                    $b++;
                }
                $dig = $soma % 9;

                return ($dig == $ie[8]);
            }
        }
    }

    public function validateIncricaoEstadualSC($ie) {
        if (strlen($ie) != 9) {
            return 0;
        } else {
            $b = 9;
            $soma = 0;
            for ($i = 0; $i <= 7; $i++) {
                $soma += $ie[$i] * $b;
                $b--;
            }
            $dig = 11 - ($soma % 11);
            if ($dig <= 1) {
                $dig = 0;
            }

            return ($dig == $ie[8]);
        }
    }

    public function validateIncricaoEstadualSP($ie) {
        if (strtoupper(substr($ie, 0, 1)) == 'P') {
            if (strlen($ie) != 13) {
                return 0;
            } else {
                $b = 1;
                $soma = 0;
                for ($i = 1; $i <= 8; $i++) {
                    $soma += $ie[$i] * $b;
                    $b++;
                    if ($b == 2) {
                        $b = 3;
                    }
                    if ($b == 9) {
                        $b = 10;
                    }
                }
                $dig = $soma % 11;
                return ($dig == $ie[9]);
            }
        } else {
            if (strlen($ie) != 12) {
                return 0;
            } else {
                $b = 1;
                $soma = 0;
                for ($i = 0; $i <= 7; $i++) {
                    $soma += $ie[$i] * $b;
                    $b++;
                    if ($b == 2) {
                        $b = 3;
                    }
                    if ($b == 9) {
                        $b = 10;
                    }
                }
                $dig = $soma % 11;
                if ($dig > 9) {
                    $dig = 0;
                }

                if ($dig != $ie[8]) {
                    return 0;
                } else {
                    $b = 3;
                    $soma = 0;
                    for ($i = 0; $i <= 10; $i++) {
                        $soma += $ie[$i] * $b;
                        $b--;
                        if ($b == 1) {
                            $b = 10;
                        }
                    }
                    $dig = $soma % 11;

                    return ($dig == $ie[11]);
                }
            }
        }
    }

    public function validateIncricaoEstadualSE($ie) {
        if (strlen($ie) != 9) {
            return 0;
        } else {
            $b = 9;
            $soma = 0;
            for ($i = 0; $i <= 7; $i++) {
                $soma += $ie[$i] * $b;
                $b--;
            }
            $dig = 11 - ($soma % 11);
            if ($dig > 9) {
                $dig = 0;
            }

            return ($dig == $ie[8]);
        }
    }

    public function validateIncricaoEstadualTO($ie) {
        if (strlen($ie) != 11) {
            return 0;
        } else {
            $s = substr($ie, 2, 2);
            if (!( ($s == '01') || ($s == '02') || ($s == '03') || ($s == '99') )) {
                return 0;
            } else {
                $b = 9;
                $soma = 0;
                for ($i = 0; $i <= 9; $i++) {
                    if (!(($i == 2) || ($i == 3))) {
                        $soma += $ie[$i] * $b;
                        $b--;
                    }
                }
                $i = $soma % 11;
                if ($i < 2) {
                    $dig = 0;
                } else {
                    $dig = 11 - $i;
                }

                return ($dig == $ie[10]);
            }
        }
    }

}
