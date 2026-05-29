<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    'accepted'             => ':attribute باید پذیرفته شود.',
    'active_url'           => ':attribute یک آدرس معتبر نیست.',
    'after'                => ':attribute باید تاریخی بعد از :date باشد.',
    'after_or_equal'       => ':attribute باید تاریخی بعد از :date یا برابر با آن باشد.',
    'alpha'                => ':attribute باید فقط شامل حروف باشد.',
    'alpha_dash'           => ':attribute باید فقط شامل حروف، اعداد، خط تیره و زیرخط باشد.',
    'alpha_num'            => ':attribute باید فقط شامل حروف و اعداد باشد.',
    'array'                => ':attribute باید یک آرایه باشد.',
    'before'               => ':attribute باید تاریخی قبل از :date باشد.',
    'before_or_equal'      => ':attribute باید تاریخی قبل از :date یا برابر با آن باشد.',
    'between'              => [
        'numeric' => ':attribute باید بین :min و :max باشد.',
        'file'    => ':attribute باید بین :min و :max کیلوبایت باشد.',
        'string'  => ':attribute باید بین :min و :max کاراکتر باشد.',
        'array'   => ':attribute باید بین :min و :max آیتم باشد.',
    ],
    'boolean'              => 'فیلد :attribute باید صحیح یا غلط باشد.',
    'confirmed'            => 'تاییدیه :attribute مطابقت ندارد.',
    'date'                 => ':attribute یک تاریخ معتبر نیست.',
    'date_equals'          => ':attribute باید تاریخی برابر با :date باشد.',
    'date_format'          => ':attribute با فرمت :format مطابقت ندارد.',
    'different'            => ':attribute و :other باید متفاوت باشند.',
    'digits'               => ':attribute باید :digits رقم باشد.',
    'digits_between'       => ':attribute باید بین :min و :max رقم باشد.',
    'dimensions'           => 'ابعاد تصویر :attribute معتبر نیست.',
    'distinct'             => 'فیلد :attribute دارای مقدار تکراری است.',
    'email'                => ':attribute باید یک آدرس ایمیل معتبر باشد.',
    'ends_with'            => ':attribute باید با یکی از مقادیر زیر تمام شود: :values',
    'exists'               => ':attribute انتخاب شده معتبر نیست.',
    'file'                 => ':attribute باید یک فایل باشد.',
    'filled'               => 'فیلد :attribute الزامی است.',
    'gt'                   => [
        'numeric' => ':attribute باید بزرگتر از :value باشد.',
        'file'    => ':attribute باید بزرگتر از :value کیلوبایت باشد.',
        'string'  => ':attribute باید بزرگتر از :value کاراکتر باشد.',
        'array'   => ':attribute باید بیشتر از :value آیتم داشته باشد.',
    ],
    'gte'                  => [
        'numeric' => ':attribute باید بزرگتر یا برابر :value باشد.',
        'file'    => ':attribute باید بزرگتر یا برابر :value کیلوبایت باشد.',
        'string'  => ':attribute باید بزرگتر یا برابر :value کاراکتر باشد.',
        'array'   => ':attribute باید :value آیتم یا بیشتر داشته باشد.',
    ],
    'image'                => ':attribute باید یک تصویر باشد.',
    'in'                   => ':attribute انتخاب شده معتبر نیست.',
    'in_array'             => 'فیلد :attribute در :other وجود ندارد.',
    'integer'              => ':attribute باید یک عدد صحیح باشد.',
    'ip'                   => ':attribute باید یک آدرس IP معتبر باشد.',
    'ipv4'                 => ':attribute باید یک آدرس IPv4 معتبر باشد.',
    'ipv6'                 => ':attribute باید یک آدرس IPv6 معتبر باشد.',
    'json'                 => ':attribute باید یک رشته JSON معتبر باشد.',
    'lt'                   => [
        'numeric' => ':attribute باید کوچکتر از :value باشد.',
        'file'    => ':attribute باید کوچکتر از :value کیلوبایت باشد.',
        'string'  => ':attribute باید کوچکتر از :value کاراکتر باشد.',
        'array'   => ':attribute باید کمتر از :value آیتم داشته باشد.',
    ],
    'lte'                  => [
        'numeric' => ':attribute باید کوچکتر یا برابر :value باشد.',
        'file'    => ':attribute باید کوچکتر یا برابر :value کیلوبایت باشد.',
        'string'  => ':attribute باید کوچکتر یا برابر :value کاراکتر باشد.',
        'array'   => ':attribute نباید بیشتر از :value آیتم داشته باشد.',
    ],
    'max'                  => [
        'numeric' => ':attribute نباید بزرگتر از :max باشد.',
        'file'    => 'حجم :attribute نباید بیشتر از :max کیلوبایت باشد.',
        'string'  => ':attribute نباید بیشتر از :max کاراکتر باشد.',
        'array'   => ':attribute نباید بیشتر از :max آیتم داشته باشد.',
    ],
    'mimes'                => ':attribute باید فایلی با فرمت :values باشد.',
    'mimetypes'            => ':attribute باید فایلی با فرمت :values باشد.',
    'min'                  => [
        'numeric' => ':attribute باید حداقل :min باشد.',
        'file'    => 'حجم :attribute باید حداقل :min کیلوبایت باشد.',
        'string'  => ':attribute باید حداقل :min کاراکتر باشد.',
        'array'   => ':attribute باید حداقل :min آیتم داشته باشد.',
    ],
    'not_in'               => ':attribute انتخاب شده معتبر نیست.',
    'not_regex'            => 'فرمت :attribute معتبر نیست.',
    'numeric'              => ':attribute باید یک عدد باشد.',
    'password'             => 'رمز عبور اشتباه است.',
    'present'              => 'فیلد :attribute باید وجود داشته باشد.',
    'regex'                => 'فرمت :attribute معتبر نیست.',
    'required'             => 'فیلد :attribute الزامی است.',
    'required_if'          => 'هنگامی که :other برابر با :value است، فیلد :attribute الزامی است.',
    'required_unless'      => 'فیلد :attribute الزامی است مگر اینکه :other در :values باشد.',
    'required_with'        => 'هنگامی که :values وجود دارد، فیلد :attribute الزامی است.',
    'required_with_all'    => 'هنگامی که :values وجود دارند، فیلد :attribute الزامی است.',
    'required_without'     => 'هنگامی که :values وجود ندارد، فیلد :attribute الزامی است.',
    'required_without_all' => 'هنگامی که هیچ یک از :values وجود ندارند، فیلد :attribute الزامی است.',
    'same'                 => ':attribute و :other باید یکسان باشند.',
    'size'                 => [
        'numeric' => ':attribute باید :size باشد.',
        'file'    => ':attribute باید :size کیلوبایت باشد.',
        'string'  => ':attribute باید :size کاراکتر باشد.',
        'array'   => ':attribute باید شامل :size آیتم باشد.',
    ],
    'starts_with'          => ':attribute باید با یکی از مقادیر زیر شروع شود: :values',
    'string'               => ':attribute باید یک رشته باشد.',
    'timezone'             => ':attribute باید یک منطقه زمانی معتبر باشد.',
    'unique'               => ':attribute قبلاً انتخاب شده است.',
    'uploaded'             => 'آپلود :attribute شکست خورد.',
    'url'                  => 'فرمت :attribute معتبر نیست.',
    'uuid'                 => ':attribute باید یک UUID معتبر باشد.',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap our attribute placeholder
    | with something more reader friendly such as "E-Mail Address" instead
    | of "email". This simply helps us make our message more expressive.
    |
    */

    'attributes' => [
        'name'                  => 'نام',
        'username'              => 'نام کاربری',
        'email'                 => 'ایمیل',
        'first_name'            => 'نام',
        'last_name'             => 'نام خانوادگی',
        'password'              => 'رمز عبور',
        'password_confirmation' => 'تاییدیه رمز عبور',
        'city'                  => 'شهر',
        'country'               => 'کشور',
        'address'               => 'آدرس',
        'phone'                 => 'تلفن',
        'mobile'                => 'تلفن همراه',
        'age'                   => 'سن',
        'sex'                   => 'جنسیت',
        'gender'                => 'جنسیت',
        'day'                   => 'روز',
        'month'                 => 'ماه',
        'year'                  => 'سال',
        'hour'                  => 'ساعت',
        'minute'                => 'دقیقه',
        'second'                => 'ثانیه',
        'title'                 => 'عنوان',
        'text'                  => 'متن',
        'content'               => 'محتوا',
        'description'           => 'توضیحات',
        'excerpt'               => 'گزیده',
        'date'                  => 'تاریخ',
        'time'                  => 'زمان',
        'available'             => 'موجود',
        'size'                  => 'اندازه',
        'file_path'             => 'فایل صوتی',
        'file_path_128'         => 'فایل صوتی ۱۲۸',
        'cover_image'           => 'تصویر کاور',
        'artist_id'             => 'هنرمند',
        'album_id'              => 'آلبوم',
        'genre_id'              => 'ژانر',
    ],

];
