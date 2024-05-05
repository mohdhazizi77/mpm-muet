<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;

use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

use App\Models\User;
use App\Models\Candidate;
use App\Models\Certificate;
use App\Models\ExamSession;

class ImportCandidate implements ToCollection
{
    /**
    * @param Collection $collection
    */
    public function collection(Collection $rows)
    {

        $totalCount = count($rows);
        $processedCount = 0;

        foreach ($rows as $key => $row) {
            if ($key == 0)
                continue;

            $nric = $row[3];
            if (strpos($nric, '-') !== false) {
                $nric = str_replace('-', '', $nric); // buang '-' dekat ic
            }

            $address = [
                'address1' => $row[4],
                'address2' => $row[5],
                'postcode' => $row[6],
                'city'     => $row[7],
                'state'    => $row[8],
            ];
            $userData = [
                'name'     => $row[2],
                'address'  => serialize($address),
                'password' => Hash::make($nric),
            ];
            $user = User::updateOrCreate(['identity_card_number' => $nric], $userData);
            $user->assignRole('CALON');

            //find index_number in Candidate table
            //if not found then create new Candidate
            //if found return user_id.
            //compare user_id with $user->id
            // if same then continue
            // if not same then contniue, add log row ke berapa got duplicate angka giliran | format : row no. , angka giliran , nama ,user_id |current import
            $idx_num = $row[9];
            // $candidateData = [
            //     'user_id' => $user->id,
            // ];
            // $user = Candidate::updateOrCreate(['index_number' => $idx_num], $candidateData);
            // try {
            //     $candidate = Candidate::create([
            //         'user_id'       => $user->id,
            //         'index_number'  => $idx_num,
            //     ]);
            // } catch (\Throwable $th) {
            //     Log::info('Angka giliran already exist '.$idx_num.'\n Skip record row number: '.($key+1).'\n Error: '.$th);
            //     continue;
            //     //throw $th;
            // }

            $result = [
                'listening' => $row[12],
                'speaking'  => $row[13],
                'reading'   => $row[14],
                'writing'   => $row[15],
                'agg_score' => $row[16],
                'band'      => $row[17],
            ];

            list($session1, $session2, $year) = explode(' ', $row[1], 3);
            $session = $session1." ".$session2;

            // Check if a record with the same session and year exists
            $session_rec = ExamSession::where('name', $session)->where('year', $year)->first();

            if ($session_rec) {
                $sessionId = $session_rec->id;
                Log::info('Session Record:', ['session_rec' => $session_rec]);
            } else {
                $newSession = ExamSession::create([
                    'name' => $session,
                    'year' => $year,
                    'exam_type' => 'MUET', //need to state in excel
                ]);
                $sessionId = $newSession->id;
            }

            try {
                $certificate = Certificate::create([
                    'user_id'           => $user->id,
                    'index_number'      => $idx_num,
                    'cid'               => $row[0],
                    'exam_session_id'   => $sessionId,
                    'result'            => serialize($result),
                    'issue_date'        => date('Y-m-d H:i:s', strtotime($row[10])), //E.g '10 January 2024'
                    'expire_date'       => date('Y-m-d H:i:s', strtotime($row[11])), //E.g '10 January 2024',
                    'muet_center_id'    => 1,
                ]);
            } catch (\Throwable $th) {
                Log::info('Angka giliran already exist '.$idx_num.'\n Skip record row number: '.($key+1).'\n Error: '.$th);
                continue;
                //throw $th;
            }


            $processedCount++;
        }

        Log::info('Processed '.$processedCount.' out of '.$totalCount.' rows');
        Log::info('Script completed successfully. Everything looks good ['.date('Y-m-d H:i:s').']');


    }
}

