$table->foreign('user_id')->references('id')->on('users')

    ->onDelete('cascade');

$table->foreign('project_id')->references('id')->on('projects')

    ->onDelete('cascade');

$table->foreign('user_id')->references('id')->on('users')

->onDelete('cascade');

$table->foreign('issue_id')->references('id')->on('issues')

->onDelete('cascade');
