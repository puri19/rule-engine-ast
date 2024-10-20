<?php
// Database connection
$conn = new mysqli('localhost', 'root', '', 'rule_engine_db');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Function to create AST nodes
class Node {
    public $type;
    public $left;
    public $right;
    public $value;

    function __construct($type, $value = null, $left = null, $right = null) {
        $this->type = $type;
        $this->value = $value;
        $this->left = $left;
        $this->right = $right;
    }
}

// Create Rule (Convert string to AST and store in DB)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['rule_string'])) {
    $rule_string = $_POST['rule_string'];
    $sql = "INSERT INTO Rules (rule_string) VALUES ('$rule_string')";
    if ($conn->query($sql) === TRUE) {
        $rule_id = $conn->insert_id;
        echo json_encode(['message' => 'Rule created successfully', 'id' => $rule_id]);
    } else {
        echo json_encode(['error' => 'Error creating rule']);
    }
}

// Evaluate Rule
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['evaluate_rule'])) {
    $rule_id = $_POST['rule_id'];
    $age = $_POST['age'];
    $department = $_POST['department'];

    // Fetch rule from DB using the rule_id
    $result = $conn->query("SELECT rule_string FROM Rules WHERE id = $rule_id");
    $rule = $result->fetch_assoc()['rule_string'];

    // Replace placeholders in the rule with actual user input values
    $rule = str_replace('age', $age, $rule);  // Replace age as a number
    $rule = str_replace("department", "'$department'", $rule);  // Replace department as a string (with quotes)

    // Evaluate the rule using eval
    try {
        $evaluation = eval("return ($rule);");
        echo json_encode(['result' => $evaluation ? 'True' : 'False']);
    } catch (Throwable $e) {
        echo json_encode(['error' => 'Error evaluating rule: ' . $e->getMessage()]);
    }
}

// Fetch all Rules
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $result = $conn->query("SELECT * FROM Rules");
    $rules = [];
    while ($row = $result->fetch_assoc()) {
        $rules[] = $row;
    }
    echo json_encode($rules);
}

$conn->close();
?>
