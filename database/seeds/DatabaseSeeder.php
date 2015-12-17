<?php

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Eloquent::unguard();

		$this->call("AttributesTableSeeder");
		$this->call("CategoriesTableSeeder");
		$this->call("ProductsTableSeeder");

		$this->call("ProductsAttributesTableSeeder");
		$this->call("ProductsCategoriesTableSeeder");

	    $this->call('UsersTableSeeder');
	}

}
