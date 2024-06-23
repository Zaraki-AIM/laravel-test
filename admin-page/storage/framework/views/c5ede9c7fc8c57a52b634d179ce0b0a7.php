<!DOCTYPE html>
<html>

<head>
    <title>Contents List</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }

        th {
            background-color: #add8e6;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        img {
            max-width: 100px;
        }
    </style>
    <!-- HTMLの<head>内に追加 -->
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>

</head>

<body>
    <div class="container">
        <h2>Contents List</h2>
        <a href="<?php echo e(route('contents.create')); ?>" class="btn btn-primary">Create New Content</a>
        <table class="table table-bordered mt-4">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Status</th>
                    <th>Grade</th>
                    <th>Image</ th>
                    <th>Created At</th>
                    <th>Action</th>
                    <th>Recommend</th> <!-- Added Recommend Column -->
                </tr>
            </thead>
            <tbody>
                <?php $__currentLoopData = $contents; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $content): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td><?php echo e($content->title); ?></td>
                        <td><?php echo e($content->status); ?></td>
                        <td><?php echo e(is_array($content->grade) ? implode(', ', $content->grade) : $content->grade); ?></td>

                        <td>
                            <?php if($content->image): ?>
                                <img src="<?php echo e($content->image); ?>" alt="Image">
                            <?php endif; ?>
                        </td>
                        <td><?php echo e($content->created_at); ?></td>
                        <td>
                            <button class="btn btn-danger" data-toggle="modal" data-target="#deleteModal"
                                data-id="<?php echo e($content->id); ?>" data-title="<?php echo e($content->id); ?>">Delete</button>
                        </td>
                        <td>
                            <!-- Toggle Checkbox for Recommendation -->
                            <input type="checkbox" class="recommend-toggle" data-id="<?php echo e($content->id); ?>"
                                <?php echo e($content->recommended ? 'checked' : ''); ?>>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    </div>

    <!-- Modal for Confirming Recommendation -->
    <div class="modal fade" id="confirmModal" tabindex="-1" role="dialog" aria-labelledby="confirmModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmModalLabel">Confirm Action</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Are you sure you want to toggle the recommendation?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" id="confirmToggle">Confirm</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <script>
        $('.recommend-toggle').on('change', function() {
            var checkbox = $(this);
            var csrfToken = document.querySelector('meta[name="csrf-token"]');

            var confirmedAction = function() {
                fetch('/api/recommend/' + checkbox.data('id'), {
                        method: 'PUT',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                                'content')
                        },
                        body: JSON.stringify({
                            recommended_flag: checkbox.is(':checked') ? 1 : 0
                        })
                    })
                    .then(response => {
                        if (!response.ok) { // HTTPステータスが200-299以外はエラー
                            return response.json().then(err => {
                                throw err;
                            }); // JSONを解析し、エラーを投げる
                        }
                        return response.json(); // 正常なレスポンスを解析
                    })
                    .then(data => {
                        alert('Recommendation status updated successfully!');
                    })
                    .catch(error => {
                        if (error.json) { // errorがResponseオブジェクトであればjsonメソッドが存在
                            error.json().then(errorMessage => {
                                alert('Failed to update the recommendation status: ' + errorMessage
                                    .message);
                            }).catch(() => {
                                alert('Failed to parse the error message.');
                            });
                        } else {
                            alert('Failed to update the recommendation status: ' + error
                                .message); // 通常のJavaScriptエラー
                        }
                    });
            };

            $('#confirmModal').modal('show');
            $('#confirmToggle').off('click').on('click', function() {
                $('#confirmModal').modal('hide');
                confirmedAction();
            });
        });
    </script>
</body>

</html>
<?php /**PATH /var/www/html/resources/views/index.blade.php ENDPATH**/ ?>