<?php
/**
 * @author Bishwanath Jha <bishwanathkj@gmail.com>
 * Node Class represent a node of linked list
 *
 * A linked list is represented by a pointer to the first node of the linked list. The first node * is called head. If the linked list is empty, then value of head is NULL.
 * Each node in a list consists of at least two parts:
 * 1) data
 * 2) pointer to the next node
 */
class Node
{
	public $data = null;
	public $next = null;
	
	public function __construct($data)
	{
		if (!$data) {
			throw new Exception("Invalid data given");
		}

		$this->data = $data;
	}
}

/**
 * @author Bishwanath Jha <bishwanathkj@gmail.com>
 * Linked List class
 */
class LinkedList 
{
	// First element of List
	/* @var $head Node */
	public $head = null;

	// Holds the number of element in linked list
	static private $count;

	public function __construct() {
		$this->head = null;
		self::$count = 0;
	}

	public function IsEmpty() {
		return (self::$count == 0);
	}

	public function GetCount() {
		return self::$count;
	}

	public function Append($item) {
		// If the linked list is empty then insert it as first element
		if ($this->head === null) {
			$this->head = new Node($item);
		} else { // Otherwise reach to end of list and append the item
			$current = $this->head;

			// looping thru end of list
			while($current->next !== null) {
				$current = $current->next;
			}

			// Se the last node to point new node
			$current->next = new Node($item);
		}

		self::$count++;

		return $this;
	}

	public function Prepend($item) {
		$node = new Node($item);
		
		// If the linked list is empty then insert it as first element
		if ($this->head === null) {
			$this->head = $node;
		} else {
			// Link the node next to head and set the node as head
			$node->next = $this->head;
			$this->head = $node;
		}

		self::$count++;
		return $this;
	}

	// Insert data in list
	public function Insert($item, $position = null) {
		if($position && ($position < 1 || (!is_int($position) && $position != 'start' && $position != 'end'))) {
			throw new Exception("Invalid value of parameter position");
		}

		if ($position > self::$count) {
			throw new Exception('Position is greater than length of linked list');
		}

		// If position is not given or end then append at the end
		if(!$position || $position == 'end' ) {
			$this->Append($item);
		} elseif($position == 'start' || $position == 1) {
			$this->Prepend($item);
		} else {
			$current = $this->head;
			$listPos = 2;
			while($current->next !== null) {
				$previous = $current;
				$next = $current->next;

				if ($listPos == $position) {
					$node = new Node($item);
					$previous->next = $node;
					$node->next = $next;
					self::$count++;
					break;
				}

				$listPos++;
				$current = $current->next;
			}
		}

		return $this;
	}

	// Delete a node on data
	public function Delete($nodeData) {
		$current = $this->head;

		// If its first node then delete it
		if ($current->data == $nodeData) {
			$this->head = ($current->next == null) ? null : $current->next;
			self::$count--;
			return $this;
		}

		$count = 2;
		while($current->next->data != $nodeData && $count <= self::$count) {
            $current = $current->next;

            if ($count == self::$count) {
            	echo "Data ($nodeData) not found in linked list \n";
            	return $this;
            }

            $count++;
        }

        $current->next = $current->next->next;
        self::$count--;

        return $this;
	}

	public function DeleteAt($position) {
		if (!is_int($position) || $position < 1) {
			throw new Exception('Invalid position given');
		}
		if ($position > self::$count) {
			throw new Exception('Position is greater than length of linked list');
		}
		if ($this->IsEmpty()) {
			echo "Linked list is empty \n";
			return $this;
		}

		if ($position == 1) {
			$this->head = ($this->head->next === null) ? null : $this->head->next;
			self::$count--;
			return $this;
		}

		$current = $this->head;
		$nodePosition = 2;
		while ($current !== null && $nodePosition != $position) {
			$current = $current->next;
			$nodePosition++;
		}

		$current->next = $current->next->next;
		self::$count--;

		return $this;
	}

	public function PrintList() {
		if ($this->IsEmpty()) {
			echo "Linked list is empty \n";

			return;
		}

		echo 'Linked List is: ';
		$current = $this->head;
		while ($current !== null) {
			echo $current->data . '->';
			$current = $current->next;
		}

		echo "\n";

		return $this;
	}

	// Find Length of a Linked List iteratively
	static public function GetLength(LinkedList $LL) {
		$length = 0;
		$current = $LL->head;
		while($current !== null) {
			$length++;
			$current = $current->next;
		}

		return $length;
	}

	// Swap nodes in a linked list without swapping data
	public function Swap($data1, $data2) {
		if ($data1 == $data2) {
			echo "Noting to do as both are same \n";
			return $this;
		}

		$prevData1 = null;
		$data1Node = $this->head;
		while ($data1Node != null && $data1Node->data != $data1) {
			$prevData1 = $data1Node;
			$data1Node = $data1Node->next;
		}

		$prevData2 = null;
		$data2Node = $this->head;
		while ($data2Node != null && $data2Node->data != $data2) {
			$prevData2 = $data2Node;
			$data2Node = $data2Node->next;
		}

		if (!$data1Node || !$data2Node) {
			echo "Data not found in between the list \n";
			return $this;
		}

		// Set the previous pointer
		($prevData1 !== null) ? $prevData1->next = $data2Node : $this->head = $data2Node;
		($prevData2 !== null) ? $prevData2->next = $data1Node : $this->head = $data1Node;

		// Swap next pointer
		$temp = $data1Node->next;
		$data1Node->next = $data2Node->next;
		$data2Node->next = $temp;

		return $this;
	}

	static public function Reverse(LinkedList $LL) {
		// If list has no or one node then bail out
		if ($LL->head === null || $LL->head->next === null) {
			return $LL;
		}	

		$temp = $previous = null;
		$current = $LL->head;
		while($current !== null) {
			$temp = $current->next;
			$current->next = $previous;
			$previous = $current;
			$current = $temp;
		}

		$LL->head = $previous;

		return $LL;
	}

	// Get the nth node data from linked list we consider start from 1,2,3 .... n
	public function GetNth($position) {
		if (!is_int($position) || $position < 1) {
			throw new Exception("Invalid position given");
		}

		$current = $this->head;
		$count = 1;
		while($current !== null && $count < $position) {
			$current = $current->next;
			$count++;
		}

		if ($position > $count) {
			echo "Position is out of linked list \n";
			return null;
		}

		return $current;
	}

	// Traverse linked list using two pointers. Move one pointer by one and other pointer by two. When the fast pointer reaches end slow pointer will reach middle of the linked list.
	public function GetMiddle() {
		if ($this->head === null || $this->head->next === null) {
			return $this->head;
		}

		$step1Pointer = $step2Pointer = $this->head;

		while($step2Pointer !== null && $step2Pointer->next !== null) {
			$step1Pointer = $step1Pointer->next;
			$step2Pointer = $step2Pointer->next->next;
		}

		return $step1Pointer;
	}
}

// Create a new linklist class
$LinkL = new LinkedList();
$LinkL->Append(200) // Add 200
	  ->Append(400) // Add 400
      ->Append(500) // Add 500
      ->Append(600) // Add 600
      ->Append(700) // Add 600
	  ->Prepend(100) // Add 100 at first
	  ->Insert(300, 3) // Add 300 at 3 the place staring from 1
      ->Delete(200) // Delete 200
	  ->DeleteAt(1) // Delete the 4th node starting from 1
      ->PrintList(); // Print the list

// Get the count of list
echo "Length of a Linked List iteratively = " . LinkedList::GetLength($LinkL) . "\n";
echo "Length of a Linked List by checking count directly = " . $LinkL->GetCount() . "\n";

// Swap data
echo "After swaping (b/w 300, 500) the list: \n";
$LinkL->Swap(300, 500)->PrintList();

// Reverse linked list using iterative way
echo "After Reversing the list: \n";
LinkedList::Reverse($LinkL)->PrintList();

// Find the nth element from linked list
echo "3nd Element of Linked list is: " . $LinkL->GetNth(3)->data;

// Find the middle of list
echo "\nMiddle of list is: " . $LinkL->GetMiddle()->data;
