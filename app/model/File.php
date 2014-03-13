<?php
/**
 * File.php
 * @author yuuki.takezawa<yuuki.takezawa@excite.jp>
 * 2014/03/13 9:51
 */
namespace Model;
class File {

	/**
	 * Write the contents of a file.
	 * @param  string  $path
	 * @param  string  $contents
	 * @return int
	 */
	public function put($path, $contents)
	{
		return file_put_contents($path, $contents);
	}

	/**
	 * Append to a file.
	 * @param  string  $path
	 * @param  string  $data
	 * @return int
	 */
	public function append($path, $data)
	{
		return file_put_contents($path, $data, FILE_APPEND);
	}

	/**
	 * Delete the file at a given path.
	 * @param  string  $path
	 * @return bool
	 */
	public function delete($path)
	{
		return @unlink($path);
	}

	/**
	 * Move a file to a new location.
	 * @param  string  $path
	 * @param  string  $target
	 * @return void
	 */
	public function move($path, $target)
	{
		return rename($path, $target);
	}

	/**
	 * Copy a file to a new location.
	 * @param  string  $path
	 * @param  string  $target
	 * @return void
	 */
	public function copy($path, $target)
	{
		return copy($path, $target);
	}

	/**
	 * Extract the file extension from a file path.
	 * @param  string  $path
	 * @return string
	 */
	public function extension($path)
	{
		return pathinfo($path, PATHINFO_EXTENSION);
	}

	/**
	 * Get the file type of a given file.
	 * @param  string  $path
	 * @return string
	 */
	public function type($path)
	{
		return filetype($path);
	}

	/**
	 * Get the file size of a given file.
	 * @param  string  $path
	 * @return int
	 */
	public function size($path)
	{
		return filesize($path);
	}

	/**
	 * Get the file's last modification time.
	 *
	 * @param  string  $path
	 * @return int
	 */
	public function lastModified($path)
	{
		return filemtime($path);
	}

	/**
	 * Determine if the given path is a directory.
	 *
	 * @param  string  $directory
	 * @return bool
	 */
	public function isDirectory($directory)
	{
		return is_dir($directory);
	}

	/**
	 * Determine if the given path is writable.
	 *
	 * @param  string  $path
	 * @return bool
	 */
	public function isWritable($path)
	{
		return is_writable($path);
	}

	/**
	 * Determine if the given path is a file.
	 *
	 * @param  string  $file
	 * @return bool
	 */
	public function isFile($file)
	{
		return is_file($file);
	}

	/**
	 * Find path names matching a given pattern.
	 *
	 * @param  string  $pattern
	 * @param  int     $flags
	 * @return array
	 */
	public function glob($pattern, $flags = 0)
	{
		return glob($pattern, $flags);
	}

	/**
	 * Get an array of all files in a directory.
	 *
	 * @param  string  $directory
	 * @return array
	 */
	public function files($directory)
	{
		$glob = glob($directory.'/*');
		if ($glob === false) return array();

		// To get the appropriate files, we'll simply glob the directory and filter
		// out any "files" that are not truly files so we do not end up with any
		// directories in our list, but only true files within the directory.
		return array_filter($glob, function($file)
			{
				return filetype($file) == 'file';
			});
	}

	/**
	 * Create a directory.
	 *
	 * @param  string  $path
	 * @param  int     $mode
	 * @param  bool    $recursive
	 * @return bool
	 */
	public function makeDirectory($path, $mode = 0777, $recursive = false)
	{
		return mkdir($path, $mode, $recursive);
	}
}