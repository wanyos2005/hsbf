<?php

/**
 * Extends CButtonColumn class
 * @author Fred <mconyango@gmail.com>
 */
class ButtonColumn extends CButtonColumn {

        public function init()
        {
                if (empty($this->deleteConfirmation))
                        $this->deleteConfirmation = Lang::t('DELETE_CONFIRM');
                if (empty($this->header))
                        $this->header = 'Actions';
                $this->htmlOptions['class'] = isset($this->htmlOptions['class']) ? $this->htmlOptions['class'] . ' button-column' : 'button-column';
                parent::init();
        }

        /**
         * Renders a link button.
         * @param string $id the ID of the button
         * @param array $button the button configuration which may contain 'label', 'url', 'imageUrl' and 'options' elements.
         * See {@link buttons} for more details.
         * @param integer $row the row number (zero-based)
         * @param mixed $data the data object associated with the row
         */
        protected function renderButton($id, $button, $row, $data)
        {
                if (isset($button['visible']) && !$this->evaluateExpression($button['visible'], array('row' => $row, 'data' => $data)))
                        return;
                $label = isset($button['label']) ? $button['label'] : $id;
                $url = isset($button['url']) ? $this->evaluateExpression($button['url'], array('data' => $data, 'row' => $row)) : '#';
                $options = isset($button['options']) ? $button['options'] : array();
                if (!isset($options['title']))
                        $options['title'] = $label;
                $url_attribute = isset($button['url_attribute']) ? $button['url_attribute'] : 'href';
                if ($url_attribute !== 'href') {
                        $options[$url_attribute] = $url;
                        $url = '#';
                }
                if (isset($button['imageUrl']) && is_string($button['imageUrl']))
                        echo CHtml::link(CHtml::image($button['imageUrl'], $label), $url, $options);
                else {
                        echo CHtml::link($label, $url, $options);
                }
        }

}
