<?php
use Kernel\Conevert\HTML_Phinx;
use Phinx\Db\Adapter\MysqlAdapter;
use Phinx\Migration\AbstractMigration;

class ListArticles extends AbstractMigration
{
    public function change()
    {
        $this->table('list$articles', HTML_Phinx::id_default())
                ->addColumn(HTML_Phinx::id())
                ->addColumn(HTML_Phinx::select('articles'))
                ->addColumn(HTML_Phinx::number('Qte'))
                ->addColumn(HTML_Phinx::number('prix'))
                ->addColumn(HTML_Phinx::textarea('remarque'))
                ->addColumn(HTML_Phinx::datetime('date_ajoute'))
                ->addColumn(HTML_Phinx::datetime('date_modifier'))
                ->addForeignKey('articles', 'articles', 'id', ['delete' => 'CASCADE', 'update' => 'CASCADE'])
                ->create();
    }
}
