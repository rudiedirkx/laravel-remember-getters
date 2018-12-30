# Laravel remember getters

	class User extends Model {
		use RemembersAttributes;
		
		function getCheapAttribute() {
			// This is executed for every $user->cheap access
			return 13;
		}
		
		function rememberExpensiveAttribute() {
			// This is executed only once per $user, no matter how many $user->expensive accesses
			return $this->instances()->join(...)->distinct()->get();
		}
	}
