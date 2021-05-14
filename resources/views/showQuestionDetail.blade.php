<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>
    <div>
        <b>Bộ đề:</b>
       <i>{{$name_exam_question}}</i>
    </div>
    <div>
        <b>Link Exam:</b>
        <i>{{$link_exam_question}}</i>
    </div>
    <div>
        <b>Link question:</b>
        <i>{{ $question->link }}</i>
    </div>
    <div>
        <b>Câu hỏi:</b>
        <p>{!! $question->content !!}</p>
    </div>
    <div>
        <b>Đáp án lựa chọn </b>
        @foreach ($answers as $item)
            <p>{!! $item->content !!}</p>
        @endforeach
    </div>
    <div>
        <b>Lời giải</b>
        <p>{!! $question->correct_answer !!}</p>
    </div>
</body>

</html>