import React from 'react';
import TableExtended from '@hubleto/react-ui/ext/TableExtended';

class TableRenewals extends TableExtended {
  static defaultProps = {
    ...TableExtended.defaultProps,
    formUseModalSimple: true,
    model: 'Hubleto/App/Custom/Insurance/Models/Renewal'
  };

  constructor(props: any) {
    super(props);
    this.state = this.getStateFromProps(props);
  }
}

export default TableRenewals;
