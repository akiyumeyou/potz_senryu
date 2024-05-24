use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDefaultValueToImgPathInSenryusTable extends Migration
{
    public function up()
    {
        Schema::table('senryus', function (Blueprint $table) {
            $table->string('img_path')->default('')->change();
        });
    }

    public function down()
    {
        Schema::table('senryus', function (Blueprint $table) {
            $table->string('img_path')->default(null)->change();
        });
    }
}
