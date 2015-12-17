{{$php_strart}}

namespace CodeTrim\Models\Base;

use \LaravelBook\Ardent\Ardent;

class {{{$entity_name}}} extends Ardent {{$brace_strart}}
    protected $table = '{{$entity->table}}';
    protected $primaryKey = 'id';
    public $timestamps = true;

    // fillable
    protected $fillable = array(
        {{$entity->getFillable()}});

    // guared
    protected $guarded = array('id','created_at', 'updated_at');

    // rules
    public static $rules = array(
            {{$entity->getRules()}}
    );

    // relations
    public static $relationsData = array(
            {{$entity->getRelations()}}
    );



{{$brace_end}}