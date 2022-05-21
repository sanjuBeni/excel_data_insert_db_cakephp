<h2>Upload form</h2>
<?= $this->Form->create($user = null, ['enctype' => "multipart/form-data"]) ?>
<input type="file" name="file" />
<input type="submit" name="submit" value="submit" />

<?= $this->Form->end() ?>