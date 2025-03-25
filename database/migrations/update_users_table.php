use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateUsersTable extends Migration
{
/**
* Run the migrations.
*/
public function up(): void
{
Schema::table('users', function (Blueprint $table) {
$table->string('phone')->nullable();
$table->string('emergency_contact')->nullable();
$table->string('optional_emergency_contact')->nullable();
$table->string('medical_info')->nullable();
$table->text('medical_details')->nullable();
$table->string('first_name')->nullable();
$table->string('last_name')->nullable();
$table->string('gender')->nullable();
$table->string('nationality')->nullable();
$table->date('date_of_birth')->nullable();
$table->string('place_of_birth')->nullable();
$table->string('address')->nullable();
$table->string('city')->nullable();
$table->string('country')->nullable();
$table->string('trip')->nullable();
$table->string('student_number')->nullable();
$table->string('education')->nullable();
$table->string('major')->nullable();
});
}

/**
* Reverse the migrations.
*/
public function down(): void
{
Schema::table('users', function (Blueprint $table) {
$table->dropColumn([
'phone',
'emergency_contact',
'optional_emergency_contact',
'medical_info',
'medical_details',
'first_name',
'last_name',
'gender',
'nationality',
'date_of_birth',
'place_of_birth',
'address',
'city',
'country',
'trip',
'student_number',
'education',
'major',
]);
});
}
}