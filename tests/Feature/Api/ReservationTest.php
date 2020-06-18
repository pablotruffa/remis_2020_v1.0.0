<?php

namespace Tests\Feature\Api;

use Tests\TestCase;
use App\Models\RemisUsers;
use App\Models\Reservation;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ReservationTest extends TestCase
{
    use RefreshDatabase;

    protected $user;
    protected $token;
    protected $reservations = null;
    protected $reservation_status = [];

    public function setUp() :void
    {
        parent::setUp();
        Artisan::call('db:seed');
        $this->user = RemisUsers::first();
        $this->token = JWTAuth::fromUser($this->user);
        $this->fill_reservations();
    }

    public function test_user()
    {
        $this->assertInstanceOf(RemisUsers::class, $this->user);
    }
 
    public function fill_reservations()
    {
        $response = $this->withHeaders([
            'Authorization' => 'bearer '.$this->token
        ])->json('GET','api/reservations');
        $response->assertStatus(200);
        $response->assertJson([]);
        $reservations = json_decode($response->content());
        
        $reservation_status = [
            'confirmed' => 0,
            'initiated' => 0,
            'postponed' => 0,
            'cancelled' => 0,
            'completed' => 0,
        ];

        foreach($reservations as $re)
        {
            switch($re->reservation_status)
            {
                case 1: $reservation_status['confirmed']+= 1; break;
                case 2: $reservation_status['initiated']+= 1; break;
                case 3: $reservation_status['postponed']+= 1; break;
                case 4: $reservation_status['cancelled']+= 1; break;
                case 5: $reservation_status['completed']+= 1; break;
            }
        }

        $this->reservation_status = $reservation_status;
        $this->reservations = $reservations;
    }

    

    public function test_db_has_five_reservations()
    {
        $this->assertCount(5,$this->reservations);
    }
    
    public function test_get_reservation_by_id_returns_reservation_with_id_equal_to_param()
    {   
        $id = 1;
        $response = $this->db('GET','api/reservation/'.$id);
        $response->assertJson([])->assertStatus(200)->assertJsonFragment([
            'id' => $id,
        ]);
        $this->assertEquals(json_decode($response->content()),$this->reservations[$id-1]);
    
    }
    
    public function test_get_reservation_by_id_doesnt_find_reservation_and_returns_empty()
    {
        $response = $this->db('GET','api/reservation/15');
        $response->assertJson([])->assertStatus(200)->assertJsonCount(0);
        
        $this->assertArrayNotHasKey(15,$this->reservations);
    
    }
    
    public function test_get_reservations_confirmed_returns_reservations_with_status_1()
    {
        $response = $this->db('GET','api/reservations/confirmed');
        $response->assertJson([])->assertStatus(200);
        $confirmed = json_decode($response->content());
        $confirmed_db = 0;
        foreach($confirmed as $c)
        {
           $this->assertEquals(1,$c->reservation_status);
           $confirmed_db += 1;
        }

        $confirmed_local = 0;
        foreach($this->reservations as $r)
        {
            if($r->reservation_status == 1)
            {
                $confirmed_local += 1;
            }
        }

        $this->assertEquals($confirmed_local,$confirmed_db);

    }

    public function test_store_reservation_with_status_2_and_compare_before_and_after_total_amount_of_reservations()
    {   
        $before = $this->assertCount(5,$this->reservations);
        $reservation = [
            'confirmation_number'   => 666666666,
            'travel_date'           => date('Y-m-d', time()),
            'travel_time'           => '23:59',
            'origin'                => 'Origen_testing_initiated',
            'destiny'               => 'Destino_testing_initiated',
            'vehicle_quantity'      => '1',
            'price'                 => '1500',
            'commission_percentage' => '20',
            'reservation_status'    => 2,
            'id_client'             => 1,
        ];

        $response = $this->db('POST','api/reservation',$reservation);
        $response->assertJson(['created' => true,])->assertStatus(200);
        
        $db_reservation = json_decode($response->content());
        $this->assertSame($db_reservation->data->confirmation_number,$reservation['confirmation_number']);
        $this->assertEquals($db_reservation->data->reservation_status,2);

        $after = $this->assertCount(6,$this->reservations);

    }

    public function test_storing_incomplete_reservation_returns_validation_errors()
    {
        $response = $this->db('POST','api/reservation',$array = []);
        $response->assertStatus(422);
        $missing = ['travel_date','travel_time','origin','destiny','vehicle_quantity','price','commission_percentage','id_client',];
        $response->assertJsonValidationErrors($missing);
        $this->assertCount(5,$this->reservations);
    }

    public function test_get_reservations_initiated_returns_reservations_with_status_2_returns_only_one_reservation()
    {   
        $response = $this->db('GET','api/reservations/initiated');
        $response->assertJson([])->assertStatus(200)->assertJsonCount(1);
        $this->assertEquals(1,$this->reservation_status['initiated']);
        
    }
    
    public function test_get_reservations_postponed_returns_reservations_with_status_3()
    {
        $response = $this->db('GET','api/reservations/postponed');
        $response->assertJson([])->assertStatus(200)->assertJsonCount(2);
        $this->assertEquals(2,$this->reservation_status['postponed']);
        
    }
    
    public function test_get_reservations_cancelled_returns_empty_because_there_are_not_reservations_with_status_4()
    {
        $response = $this->db('GET','api/reservations/cancelled');
        $response->assertJson([])->assertStatus(200)->assertJsonCount(0);
        $this->assertEquals(0,$this->reservation_status['cancelled']);
        
    }
    
    public function test_store_reservation_with_status_5_then_check_db_has_reservation_with_status_5()
    {
        $reservation = [
            'confirmation_number'   => 6666666662,
            'travel_date'           => date('Y-m-d', time()),
            'travel_time'           => '23:59',
            'origin'                => 'Origen_testing',
            'destiny'               => 'Destino_testing',
            'vehicle_quantity'      => '1',
            'price'                 => '1500',
            'commission_percentage' => '20',
            'reservation_status'    => 5,
            'id_client'             => 1,
        ];
        
        $response = $this->db('POST','api/reservation',$reservation);
        $response->assertJson(['created' => true,]);
        $this->assertEquals(1,$this->reservation_status['completed']);

    }

    public function test_cannot_insert_a_reservation_with_past_date()
    {   
        $reservation = [
            'confirmation_number'   => 6666666663,
            'travel_date'           => '2000-01-01',
            'travel_time'           => '23:59',
            'origin'                => 'Origen_testing',
            'destiny'               => 'Destino_testing',
            'vehicle_quantity'      => '1',
            'price'                 => '1500',
            'commission_percentage' => '20',
            'reservation_status'    => 5,
            'id_client'             => 1,
        ];
        $this->assertCount(5,$this->reservations);
        $response = $this->db('POST','api/reservation',$reservation);
        $response->assertJson(['created' => false,]);
        $this->assertCount(5,$this->reservations);
    }

    public function test_get_first_reservation_then_assert_fragment_then_edit_that_reservation_then_save_it_in_db_then_get_first_reservation_again_and_assert_fragment()
    {
        $response = $this->db('GET','api/reservation/2');
        $response->assertJson([])->assertStatus(200)->assertJsonFragment([
            'id'        => 2,
            'origin'    =>'Berazategui',
            'destiny'   =>'Capital Federal',
            'travel_time'   =>'23:59:59',
        ]);

        $reservation = json_decode($response->content());
        $reservation->origin    = 'Hudson';
        $reservation->destiny   = 'Ezpeleta';
        $reservation->travel_time = '23:00';
        
        $reservation = (array)$reservation;
        $store = $this->db('PUT','api/reservation/2',$reservation);
        $store->assertJsonFragment([
            'updated'=>true,
        ]);
        $this->assertEquals('Hudson', $this->reservations[1]->origin);
       

    }

    public function test_delete_a_reservation()
    {   
        $this->assertEquals(0,$this->reservation_status['cancelled']);
        $response = $this->db('DELETE','api/reservation/1');
        $response->assertJsonFragment([
            'cancelled' => true,
        ]);
        
        $this->assertEquals(1,$this->reservation_status['cancelled']);

    }

    public function test_delete_a_reservation_fails_because_it_cant_find_the_reservation()
    {
        $response = $this->db('DELETE','api/reservation/15');
        $response->assertStatus(404);
    }
    
    
    public function db($method,$url,$array = null)
    {   
        if(!$array){
            $response = $this->withHeaders([
                'Authorization' => 'bearer '.$this->token
            ])->json($method,$url);
        }else{
            $response = $this->withHeaders([
                'Authorization' => 'bearer '.$this->token
            ])->json($method,$url,$array);
        }
        $this->fill_reservations();
        return $response;
    }

}
