<?php
namespace App\Models\Backend;

class OptionsModel extends BackendBaseModel
{
    public function __construct()
    {
        parent::__construct();
    }


    public function getOneOption($id)
    {
        $stmt = $this->pdo->prepare('SELECT * FROM options  WHERE options.id = :id');

        $stmt->bindValue(':id', $id, \PDO::FETCH_ASSOC);

        return $stmt->execute() ? $stmt->fetch(\PDO::FETCH_ASSOC) : [];
    }

    public function getOptionValues($id)
    {
        $stmt = $this->pdo->prepare('SELECT options_values.name, options_values.id 
        FROM options 
        LEFT JOIN options_values ON options.id = options_values.option_id 
        WHERE options.id = :id');

        $stmt->bindValue(':id', $id, \PDO::FETCH_ASSOC);

        return $stmt->execute() ? $stmt->fetchAll(\PDO::FETCH_ASSOC) : [];
    }

    public function searchOptions($searchText)
    {
        $stmt = $this->pdo->prepare('SELECT 
                     options.id as option_id,
                     options.name as option_name,
                     options_values.id as value_id, 
                     options_values.name as option_value,
                     options.id FROM options 
                     INNER JOIN options_values ON options_values.option_id = options.id 
                     WHERE options.name LIKE ?');

        $res = $stmt->execute(["$searchText%"]) ? $stmt->fetchAll(\PDO::FETCH_ASSOC) : [];
        $options = [];
        $optionsSorted = [];

        foreach ($res as $option) {
            if (!is_array($options[$option['option_id']])) {
                $options[$option['option_id']] = [];
                $options[$option['option_id']]['option_name'] = $option['option_name'];
                $options[$option['option_id']]['option_id'] = $res[0]['option_id'];
                $options[$option['option_id']]['values'] = [];
            }

            $options[$option['option_id']]['values'][] = [
                'option_value' => $option['option_value'],
                'id' => $$option['value_id']
            ];
        }

        foreach ($options as $option) {
            $optionsSorted[] = $option;
        }

       return $optionsSorted;
    }

    public function addValueToOption($data)
    {
        $stmt = $this->pdo->prepare('INSERT INTO options_values (name, option_id) VALUES(:value, :option_id)');

        $stmt->bindValue(':option_id', $data['optionId']);
        $stmt->bindValue(':value', $data['value']);

        return $stmt->execute();
    }

    public function editParamName($data)
    {
        $stmt = $this->pdo->prepare('UPDATE options SET name = :name WHERE id = :optionId');

        $stmt->bindValue('name', $data['name']);
        $stmt->bindValue('optionId', $data['optionId']);

        return $stmt->execute();
    }

    public function editOptionValue($data)
    {
        $stmt = $this->pdo->prepare('UPDATE options_values SET name = :name WHERE id = :valueId AND option_id = :option_id');

        $stmt->bindValue(':name', $data['value']);
        $stmt->bindValue(':valueId', $data['valueId']);
        $stmt->bindValue(':option_id', $data['optionId']);

        return $stmt->execute();
    }

    public function deleteOne($id)
    {
        $stmt = $this->pdo->prepare('DELETE FROM options_values WHERE id = ?');

        return $stmt->execute([$id]);
    }

    public function getMostPopular()
    {
        return $this->pdo->query('SELECT 
      COUNT(products_options.option_id) as countOfUses, 
      options.name,
      options.id
      FROM products_options 
      LEFT JOIN options ON options.id = products_options.option_id 
      GROUP BY options.id, options.name
      ORDER BY countOfUses LIMIT 10')->fetchAll(\PDO::FETCH_ASSOC);
    }
}